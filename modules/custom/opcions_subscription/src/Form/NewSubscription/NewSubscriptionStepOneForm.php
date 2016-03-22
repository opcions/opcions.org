<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Form\NewSubscriptionForm.
 */

namespace Drupal\opcions_subscription\Form\NewSubscription;

use Drupal\Core\Form\FormStateInterface;
use Drupal\opcions_subscription\Entity\Subscription;
use Drupal\user\Entity\User;

/**
 * Class SubscriptionForm.
 *
 * @package Drupal\opcions_subscription\Form
 */
class NewSubscriptionStepOneForm extends NewSubscriptionFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'opcions_new_subscription_one';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $form = parent::buildForm($form, $form_state);

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

    $form['paper'] = array(
      '#type' => 'checkbox',
      '#states' => [
        'disabled' => [
          '.price-select input[type="radio"]' => array('value' => '48'),
        ],
        'unchecked' => [
          '.price-select input[type="radio"]' => array('value' => '48'),
        ],

      ],
      '#attributes' => [ 'class' => [ 'switch' ]],
      '#title' => $this->t('Paper magazine (twice a year)') . '&nbsp;<span class="paper-info">' . $this->t('Paper version is only available for subscriptions from 54&euro;') . '</span>',
    );

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email'),
    ];

    $form['actions']['submit']['#value'] = $this->t('Next');

    $form['#attached']['library'][] = 'opcions_subscription/subscription-form';

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // validate form

    $email = $form_state->getValue('email');

    $this->store->set('email', $email);
    $this->store->set('price', $form_state->getValue('price'));
    $this->store->set('paper', $form_state->getValue('paper'));

    $subscription = \Drupal::service('opcions_subscription.new_subscriber')->get($email);

    $subscription->set('paper_version', $form_state->getValue('paper'));
    $subscription->set('price', $form_state->getValue('price'));
    $subscription->save();

    $this->store->set('subscription_id', $subscription->id());

    $form_state->setRedirect('opcions.new_subscription_2');
  }

}
