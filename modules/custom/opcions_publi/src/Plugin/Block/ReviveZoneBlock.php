<?php

/**
 * @file
 * Contains \Drupal\opcions_publi\Plugin\Block\ReviveZoneBlock.
 */

namespace Drupal\opcions_publi\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Language\LanguageManagerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'ReviveZoneBlock' block.
 *
 * @Block(
 *  id = "revive_zone_block",
 *  admin_label = @Translation("Revive zone block"),
 * )
 */
class ReviveZoneBlock extends BlockBase implements ContainerFactoryPluginInterface
{

  /*
   * @var Drupal\Core\Language\LanguageManagerInterface;
   */
  protected $language_manager;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, LanguageManagerInterface $language_manager)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->language_manager = $language_manager;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('language_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {
    $form['zone'] = array(
      '#type' => 'select',
      '#title' => $this->t('Zone'),
      '#description' => $this->t('Select which zone to show an ad from'),
      '#default_value' => isset($this->configuration['zone']) ? $this->configuration['zone'] : '',
      '#options' => self::getOptions(),
      '#weight' => '1',
      '#required' => true,
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $langcode = $this->language_manager->getCurrentLanguage()->getId();
    $zone = $form_state->getValue('zone');
    $config = self::getCurrentLanguageConfig($langcode, $zone);

    $this->configuration['zone'] = $zone;
    $this->configuration['zone_id'] = $config['zone_id'];
    $this->configuration['zone_display'] = $config['zone_display'];
  }

  /**
   * {@inheritdoc}
   */
  public function build()
  {
    $config = $this->getCurrentLanguageConfig();
    
    return [
      'opcions_publi_script' => [
        '#theme' => 'revive_zone_script',
        '#zone_id' => $config['zone_id'],
        '#zone_display' => $config['zone_display'],
      ],
      '#cache' => [
        'contexts' => ['languages:language_interface'],
      ],
      '#attached' => [
        'library' => [
          'opcions_publi/revive.spcjs',
          'opcions_publi/lazyads.loader'
        ],
      ],
    ];

  }

  private function getOptions()
  {
    return [
      'MRD' => $this->t('Medium Rectangle 300x250 (desktop)'),
      'LBD' => $this->t('Leaderboard 728x90 (desktop)'),
      'MRM' => $this->t('Medium Rectangle 300x250 (mobile)'),
    ];
  }

  private function getCurrentLanguageConfig()
  {
    $langcode = $this->language_manager->getCurrentLanguage()->getId();
    $zone = $this->configuration['zone'];

    $map = [
      'ca' => [
        'MRD' => ['zone_id' => 2, 'zone_display' => 'desktop'],
        'LBD' => ['zone_id' => 1, 'zone_display' => 'desktop'],
        'MRM' => ['zone_id' => 3, 'zone_display' => 'mobile'],
      ],
      'es' => [
        'MRD' => ['zone_id' => 4, 'zone_display' => 'desktop'],
        'LBD' => ['zone_id' => 6, 'zone_display' => 'desktop'],
        'MRM' => ['zone_id' => 5, 'zone_display' => 'mobile'],
      ],
    ];

    return isset($map[$langcode][$zone]) ? $map[$langcode][$zone] : $map['ca']['MRD'];
  }


}
