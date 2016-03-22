<?php

namespace Drupal\opcions_subscription\Controller;

use Drupal\Core\Controller\ControllerBase;

class SubscriptionController  extends ControllerBase
{

  /**
   * {@inheritdoc}
   */
  public function thankYouPage() {
    $build = array(
      '#type' => 'markup',
      '#markup' => t('Thanks!'),
    );
    return $build;
  }

}