<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\SubscriptionInterface.
 */

namespace Drupal\opcions_subscription;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Subscription entities.
 *
 * @ingroup opcions_subscription
 */
interface SubscriptionInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  // Possible status states.
  const STATUS_ACTIVE = 0;
  const STATUS_UNSUBSCRIBED = 1;
  const STATUS_PENDING_PAYMENT = 2;
  const STATUS_NEW = 3;
  const STATUS_EXPIRED = 4;
  const STATUS_PENDING_RENEWAL = 5;
  const STATUS_ARCHIVED = 5;

  // Add get/set methods for your configuration properties here.
  /**
   * Gets the Subscription name.
   *
   * @return string
   *   Name of the Subscription.
   */
  public function getName();

  /**
   * Sets the Subscription name.
   *
   * @param string $name
   *   The Subscription name.
   *
   * @return \Drupal\opcions_subscription\SubscriptionInterface
   *   The called Subscription entity.
   */
  public function setName($name);

  /**
   * Gets the Subscription creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Subscription.
   */
  public function getCreatedTime();

  /**
   * Sets the Subscription creation timestamp.
   *
   * @param int $timestamp
   *   The Subscription creation timestamp.
   *
   * @return \Drupal\opcions_subscription\SubscriptionInterface
   *   The called Subscription entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Returns the Subscription acitve status indicator.
   *
   * @return bool
   *   TRUE if the Subscription is active.
   */
  public function isActive();

  /**
   * Sets the published status of a Subscription.
   *
   * @param integer $stattus
   *   The status key from this inteface contants.
   *
   * @return \Drupal\opcions_subscription\SubscriptionInterface
   *   The called Subscription entity.
   */
  public function setStatus($status);

}
