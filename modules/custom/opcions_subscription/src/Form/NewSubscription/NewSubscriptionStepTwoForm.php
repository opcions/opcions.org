<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Form\NewSubscriptionForm.
 */

namespace Drupal\opcions_subscription\Form\NewSubscription;

use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Routing\LocalRedirectResponse;
use Drupal\Core\Url;
use Drupal\opcions_subscription\Entity\Subscription;
use Drupal\user\Entity\User;

/**
 * Class SubscriptionForm.
 *
 * @package Drupal\opcions_subscription\Form
 */
class NewSubscriptionStepTwoForm extends NewSubscriptionFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'opcions_new_subscription_two';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    if (!$id = $this->store->get('subscription_id')) {
      return LocalRedirectResponse::create(Url::fromRoute('opcions.new_subscription_1')->toString());
    }

    $form = parent::buildForm($form, $form_state);

    $subscription = Subscription::load($id);

    $display = EntityFormDisplay::collectRenderDisplay($subscription, 'default');

    $display->buildForm($subscription, $form, $form_state);
/*
    $element = array(
      '#title' => 'Data',
      '#description' => 'Data description',
    );

    $element = $display->getRenderer('field_address')
      ->formElement($subscription->address, 0, $element, $form, $form_state);

    $form['address'] = $element;

    $form['actions']['submit']['#value'] = $this->t('Payment');

    $form['#attached']['library'][] = 'opcions_subscription/subscription-form';
*/
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // validate form

    $email = $form_state->getValue('email');
    $subscription = \Drupal::service('opcions_subscription.new_subscriber')->get($email);

    $this->store->set('email', $email);
    $this->store->set('price', $form_state->getValue('price'));

    $subscription->save();

    $this->store->set('subscription_id', $subscription->id());

    $form_state->setRedirect('opcions.new_subscription_2');
  }

}
