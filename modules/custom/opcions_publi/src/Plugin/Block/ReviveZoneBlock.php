<?php

/**
 * @file
 * Contains \Drupal\opcions_publi\Plugin\Block\ReviveZoneBlock.
 */

namespace Drupal\opcions_publi\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'ReviveZoneBlock' block.
 *
 * @Block(
 *  id = "revive_zone_block",
 *  admin_label = @Translation("Revive zone block"),
 * )
 */
class ReviveZoneBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['zone_number'] = array(
      '#type' => 'number',
      '#title' => $this->t('Zone Number'),
      '#description' => $this->t(''),
      '#default_value' => isset($this->configuration['zone_number']) ? $this->configuration['zone_number'] : '',
      '#weight' => '1',
      '#required' => true,
    );
    $form['zone_display'] = array(
        '#type' => 'radios',
        '#title' => $this->t('Display in'),
        '#description' => $this->t(''),
        '#options' => [
          'desktop' => $this->t('Desktop'),
          'mobile' => $this->t('Mobile'),
        ],
        '#default_value' => isset($this->configuration['zone_display']) ? $this->configuration['zone_display'] : 'desktop',
        '#weight' => '2',
        '#required' => true,
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['zone_number'] = $form_state->getValue('zone_number');
    $this->configuration['zone_display'] = $form_state->getValue('zone_display');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    return [

      'opcions_publi_script' => [

        '#theme' => 'revive_zone_script',

          '#zone_id' => $this->configuration['zone_number'],
          '#zone_display' => $this->configuration['zone_display'],

      ],

      '#attached' => [

          'library' => [

            'opcions_publi/revive.spcjs',
            'opcions_publi/lazyads.loader'

          ],

      ],

    ];

  }

}
