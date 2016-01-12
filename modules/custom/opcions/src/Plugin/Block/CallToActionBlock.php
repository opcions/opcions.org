<?php

namespace Drupal\opcions\Plugin\Block;

use Drupal\block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'Call To Action' block.
 *
 * @Block(
 *   id = "opcions_cta_block",
 *   admin_label = @Translation("Call To Action block"),
 * )
 */

class CallToActionBlock extends BlockBase {

    /**
     * {@inheritdoc}
     */
    public function build() {
        return array(
            '#markup' => $this->t('Hello World!'),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function blockForm($form, &$form_state) {

        $form = parent::blockForm($form, $form_state);

        $config = $this->getConfiguration();

        $form['opcions_cta_block_settings'] = array(
            '#type' => 'textfield',
            '#title' => $this->t('Who'),
            '#description' => $this->t('Who do you want to say hello to?'),
            '#default_value' => isset($config['demo_block_settings']) ? $config['demo_block_settings'] : '',
        );

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function access(AccountInterface $account) {
        return $account->hasPermission('access content');
    }

}