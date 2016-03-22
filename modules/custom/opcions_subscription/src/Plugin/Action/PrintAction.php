<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Plugin\Action\PrintAction.
 */

namespace Drupal\opcions_subscription\Plugin\Action;

use Drupal\Core\Action\ActionBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'PrintAction' action.
 *
 * @Action(
 *  id = "print_action",
 *  label = @Translation("Print action"),
 *  type = "subscription",
 * )
 */
class PrintAction extends ActionBase {
  /**
   * {@inheritdoc}
   */
  public function execute($object = NULL) {
    // Insert code here.
  }

  /**
   * {@inheritdoc}
   */
  public function access($object, AccountInterface $account = NULL, $return_as_object = FALSE) {
    /** @var \Drupal\user\UserInterface $object */
    $access = $object->status->access('edit', $account, TRUE)
      ->andIf($object->access('update', $account, TRUE));

    return $return_as_object ? $access : $access->isAllowed();
  }

}
