<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Entity\Subscription.
 */

namespace Drupal\opcions_subscription\Entity;

use Drupal\views\EntityViewsData;
use Drupal\views\EntityViewsDataInterface;

/**
 * Provides Views data for Subscription entities.
 */
class SubscriptionViewsData extends EntityViewsData implements EntityViewsDataInterface {
  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    $data['subscription']['table']['base'] = array(
      'field' => 'id',
      'title' => $this->t('Subscription'),
      'help' => $this->t('The Subscription ID.'),
    );

    return $data;
  }

}
