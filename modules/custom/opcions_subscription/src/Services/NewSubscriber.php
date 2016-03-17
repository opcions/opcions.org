<?php

namespace Drupal\opcions_subscription\Services;

use Drupal\opcions_subscription\Entity\Subscription;
use Drupal\user\Entity\User;

class NewSubscriber {

  /**
   * @param $email
   *
   * @return Drupal\user\Entity\User
   */
  public function get($email) {

    $ids = \Drupal::entityQuery('subscription')
      ->condition('email', $email)
      ->execute();
    
    if (empty($ids) ) {
      $subscription = Subscription::create(['email' => $email]);
      $subscription->save();
    }
    else {
      $subscription = Subscription::load(array_pop($ids));
    }

    return $subscription;
  }
}
