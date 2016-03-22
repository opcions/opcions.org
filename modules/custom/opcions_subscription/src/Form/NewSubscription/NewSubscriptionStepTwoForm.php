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

    $disable = ['email', 'price', 'wants_paper'];
    foreach ($disable as $field) {
      $form[$field]['#disabled'] = TRUE;
    }

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {


    $subscription = \Drupal::service('opcions_subscription.new_subscriber')->getById($this->store->get('subscription_id'));

    $subscription->set('field_address', $form_state->getValue('field_address'));

    $subscription->save();

    $form_state->setRedirect('opcions.new_subscription_thanks');
  }

}
