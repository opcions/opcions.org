<?php

/**
 * @file
 * Contains \Drupal\referenced_by\Plugin\Condition\ReferencedBy.
 */

namespace Drupal\referenced_by\Plugin\Condition;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Condition\ConditionPluginBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Config\Entity\ConfigEntityStorageInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
* Provides a 'Referenced by' condition to check if other entities reference the current one.
*
* @Condition(
*   id = "referenced_by",
*   label = @Translation("Referenced by"),
*   context = {
*     "node" = @ContextDefinition("entity:node", required = TRUE , label = @Translation("node"))
*   }
* )
*
*/
class ReferencedBy extends ConditionPluginBase implements ContainerFactoryPluginInterface {

    /**
     * The field config storage
     *
     * @var ConfigEntityStorageInterface
     */
    protected $fieldConfigStorage;



    /**
     * Creates a new ExampleCondition instance.
     *
     * @param array $configuration
     *   The plugin configuration, i.e. an array with configuration values keyed
     *   by configuration option name. The special key 'context' may be used to
     *   initialize the defined contexts by setting it to an array of context
     *   values keyed by context names.
     * @param string $plugin_id
     *   The plugin_id for the plugin instance.
     * @param mixed $plugin_definition
     *   The plugin implementation definition.
     */
    public function __construct(ConfigEntityStorageInterface $config_storage, array $configuration, $plugin_id, $plugin_definition) {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->fieldConfigStorage = $config_storage;
    }



    /**
     * {@inheritdoc}
     */
    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {

        return new static(
            $container->get('entity_type.manager')->getStorage('field_config'),
            $configuration,
            $plugin_id,
            $plugin_definition
        );

    }

     /**
       * {@inheritdoc}
       */
     public function buildConfigurationForm(array $form, FormStateInterface $form_state) {

         $options = [];
         foreach($this->fieldConfigStorage->loadMultiple() as $fieldConfig) {
             $settings = $fieldConfig->getSettings();
             if ($fieldConfig->getType() == 'entity_reference') {
                 $options[$fieldConfig->getName()] = $fieldConfig->label();
             }
         }

         $form['referenced_by'] = array(
             '#type' => 'checkboxes',
             '#title' => $this->t('Select field'),
             '#default_value' => $this->configuration['referenced_by'],
             '#options' => $options,
             '#description' => $this->t('If the selected field is referencing the viewed entity the block will be shown.'),
         );

         return parent::buildConfigurationForm($form, $form_state);
     }

    /**
     * {@inheritdoc}
     */
     public function submitConfigurationForm(array &$form, FormStateInterface $form_state) {
         $this->configuration['referenced_by'] = array_filter($form_state->getValue('referenced_by'));
         parent::submitConfigurationForm($form, $form_state);
     }

    /**
     * {@inheritdoc}
     */
     public function defaultConfiguration() {
        return array('referenced_by' => array()) + parent::defaultConfiguration();
     }

    /**
      * Evaluates the condition and returns TRUE or FALSE accordingly.
      *
      * @return bool
      *   TRUE if the condition has been met, FALSE otherwise.
      */
      public function evaluate() {
          if (empty($this->configuration['referenced_by']) && !$this->isNegated()) {
              return TRUE;
          }

          $node = $this->getContextValue('node');

          $query = \Drupal::entityQuery('paragraph', 'OR');

          foreach ($this->configuration['referenced_by'] as $id) {
              $query->condition($id, $node->id());
          }

          $result = $query->execute();

          return !empty($result);
      }

    /**
     * Provides a human readable summary of the condition's configuration.
     */
     public function summary()
     {
         if (count($this->configuration['referenced_by']) > 1) {
             $fields = $this->configuration['referenced_by'];
             $last = array_pop($fields);
             $fields = implode(', ', $fields);
             return $this->t('The node is referenced by @fields or @last', array('@fields' => $fields, '@last' => $last));
         }
         $field = reset($this->configuration['referenced_by']);
         return $this->t('The node is referenced by @field', array('@field' => $field));
     }

}
