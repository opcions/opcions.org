<?php

namespace Drupal\opcions_subscription\Services;

use Drupal\user\Entity\User;

class NewSubscriber {

  /**
   * @param $email
   *
   * @return Drupal\user\Entity\User
   */
  public function get($email) {

    $user_id = \Drupal::entityQuery('user')
      ->condition('mail', $email)
      ->execute();

    if (empty($user_id) ) {
      $user = User::create(['mail' => $email]);
      $user->save();
    }
    else {
      $user = User::load(array_pop($user_id));
    }

    return $user;
  }
}