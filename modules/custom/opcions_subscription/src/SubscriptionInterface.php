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
   * Returns the Subscription published status indicator.
   *
   * Unpublished Subscription are only visible to restricted users.
   *
   * @return bool
   *   TRUE if the Subscription is published.
   */
  public function isPublished();

  /**
   * Sets the published status of a Subscription.
   *
   * @param bool $published
   *   TRUE to set this Subscription to published, FALSE to set it to unpublished.
   *
   * @return \Drupal\opcions_subscription\SubscriptionInterface
   *   The called Subscription entity.
   */
  public function setPublished($published);

}
