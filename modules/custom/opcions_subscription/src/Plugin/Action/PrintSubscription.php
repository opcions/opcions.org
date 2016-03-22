<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Plugin\Action\PrintSubscription.
 */

namespace Drupal\opcions_subscription\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\user\PrivateTempStore;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Prints subscriptions based on template.
 *
 * @Action(
 *   id = "subscription_print_action",
 *   label = @Translation("Print subscription as PDF"),
 *   type = "subscription",
 *   confirm_form_route_name = "opcions.confirm_print_subscription"
 * )
 */
class PrintSubscription extends ActionBase implements ContainerFactoryPluginInterface {

  /**
   * The tempstore factory.
   *
   * @var \Drupal\user\PrivateTempStore
   */
  protected $store;

  /**
   * Constructs a new DeleteNode object.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param PrivateTempStore $private_temp_store
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, PrivateTempStore $private_temp_store) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->store = $private_temp_store;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('user.private_tempstore')->get('opcions_print_subscription')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function executeMultiple(array $objects = []) {
    $this->store->set('subscriptions', $objects);
  }

  /**
   * {@inheritdoc}
   */
  public function execute($object = NULL) {
    $this->executeMultiple(array($object));
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\opcions_subscription\Entity\Subscription $object */
    return $object->access('administer subscription entities', $account, $return_as_object);
  }

}
