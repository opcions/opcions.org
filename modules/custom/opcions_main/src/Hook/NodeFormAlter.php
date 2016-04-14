<?php

namespace Drupal\opcions_main\Hook;


use Drupal\Core\Form\FormStateInterface;

class NodeFormAlter
{

  /**
   * @param $form
   * @param FormStateInterface $form_state
   */
  public function alter(&$form, FormStateInterface $form_state) {

    // Add scheduling field to author group
    $form['field_scheduled_at']['#group'] = 'author';

    // Create new group for premium access
    $form['opcions_premium'] = [
      '#type' => 'details',
      '#title' => t('Access per a socis'),
      '#group' => 'advanced',
      '#weight' => -10,
      '#open' => true,
      '#attributes' => ['class' => 'node-premium-access']
    ];

    // Move premium access fields into group
    $form['field_is_premium_content']['#group'] = 'opcions_premium';
    $form['field_free_access_at']['#group'] = 'opcions_premium';
    $form['field_free_access_at']['#states'] = [
      'invisible' => [
        ':input[name="field_is_premium_content[value]"]' => ['checked' => FALSE],
      ],
    ];

  }

}