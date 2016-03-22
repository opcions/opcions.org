<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\SubscriptionListBuilder.
 */

namespace Drupal\opcions_subscription;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Routing\LinkGeneratorTrait;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Subscription entities.
 *
 * @ingroup opcions_subscription
 */
class SubscriptionListBuilder extends EntityListBuilder {
  use LinkGeneratorTrait;
  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Subscription ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\opcions_subscription\Entity\Subscription */
    $row['id'] = $entity->id();
    $row['email'] = $this->l(
      $entity->label(),
      new Url(
        'entity.subscription.edit_form', array(
          'subscription' => $entity->id(),
        )
      )
    );
    return $row + parent::buildRow($entity);
  }

}
