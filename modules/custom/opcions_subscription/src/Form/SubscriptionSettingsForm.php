<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Form\SubscriptionSettingsForm.
 */

namespace Drupal\opcions_subscription\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SubscriptionSettingsForm.
 *
 * @package Drupal\opcions_subscription\Form
 *
 * @ingroup opcions_subscription
 */
class SubscriptionSettingsForm extends FormBase {
  /**
   * Returns a unique string identifying the form.
   *
   * @return string
   *   The unique string identifying the form.
   */
  public function getFormId() {
    return 'subscription_settings';
  }

  /**
   * Form submission handler.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Empty implementation of the abstract submit class.
  }


  /**
   * Defines the settings form for Subscription entities.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   Form definition array.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['subscription_settings']['#markup'] = 'Settings form for Subscription entities. Manage field settings here.';

//    $form['subscription_settings']['allowed_values']

    return $form;
  }

}
