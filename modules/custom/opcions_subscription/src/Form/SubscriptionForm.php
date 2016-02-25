<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Form\SubscriptionForm.
 */

namespace Drupal\opcions_subscription\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for Subscription edit forms.
 *
 * @ingroup opcions_subscription
 */
class SubscriptionForm extends ContentEntityForm {
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\opcions_subscription\Entity\Subscription */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    $status = parent::save($form, $form_state);

    switch ($status) {
      case SAVED_NEW:
        drupal_set_message($this->t('Created the %label Subscription.', [
          '%label' => $entity->label(),
        ]));
        break;

      default:
        drupal_set_message($this->t('Saved the %label Subscription.', [
          '%label' => $entity->label(),
        ]));
    }
    $form_state->setRedirect('entity.subscription.canonical', ['subscription' => $entity->id()]);
  }

}
