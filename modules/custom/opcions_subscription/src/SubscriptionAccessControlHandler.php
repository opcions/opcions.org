<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\SubscriptionAccessControlHandler.
 */

namespace Drupal\opcions_subscription;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Subscription entity.
 *
 * @see \Drupal\opcions_subscription\Entity\Subscription.
 */
class SubscriptionAccessControlHandler extends EntityAccessControlHandler {
  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\opcions_subscription\SubscriptionInterface $entity */
    switch ($operation) {
      case 'view':
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished subscription entities');
        }
        return AccessResult::allowedIfHasPermission($account, 'view published subscription entities');

      case 'update':
        return AccessResult::allowedIfHasPermission($account, 'edit subscription entities');

      case 'delete':
        return AccessResult::allowedIfHasPermission($account, 'delete subscription entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add subscription entities');
  }

}
