<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Form\SubscriptionForm.
 */

namespace Drupal\opcions_subscription\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\opcions_subscription\Entity\Subscription;
use Drupal\user\Entity\User;

/**
 * Class SubscriptionForm.
 *
 * @package Drupal\opcions_subscription\Form
 */
class NewSubscriptionForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'subscription_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form['price'] = array(
      '#type' => 'radios',
      '#options' => [
        48 => '48&euro;',
        54 => '54&euro;',
        60 => '60&euro;',
        72 => '72&euro;',
        84 => '84&euro;',
        108 => '108&euro;',
        132 => '132&euro;',
        180 => '180&euro;',
        //'custom' => $this->t('Other'),
        ],
      '#default_value' => 60,
      '#title' => $this->t('Choose a subscription price'),
      '#attributes' => [ 'class' => ['price-select'] ],

    );

    $form['price_custom'] = array(
      '#type' => 'number',
      '#title' => $this->t('price'),
      '#states' => [
        'visible' => [
          '.price-select input[type="radio"]' => array('value' => 'custom'),
        ],
      ]
    );

    $form['paper'] = array(
      '#type' => 'switch',
      '#states' => [
        'disabled' => [
          '.price-select input[type="radio"]' => array('value' => '48'),
        ],
        'unchecked' => [
          '.price-select input[type="radio"]' => array('value' => '48'),
        ],

      ],
      '#title' => $this->t('Paper magazine (twice a year)') . '&nbsp;<span class="paper-info">' . $this->t('Paper version is only available for subscriptions from 54&euro;') . '</span>',
    );

    $form['email'] = array(
      '#type' => 'email',
      '#title' => $this->t('Email'),
    );

    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    );

    $form['#attached']['library'][] = 'opcions_subscription/subscription-form';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // validate form

    $email = $form_state->getValue('email');
    $user = \Drupal::service('opcions_subscription.new_subscriber')->get($email);

    // redirect with waring if user has subscription
    $subscription = Subscription::create(['user_id' => $user->id()]);

    $subscription->set('name', $email);
    $subscription->save();


    // create subscription and attach to user

    // sent email



    kint($form_state);
  }

}
