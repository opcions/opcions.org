<?php

/**
 * @file
 * Definition of \Drupal\ckeditorfootnotes\Plugin\CKEditorPlugin\CKEditorFootnotes.
 */

namespace Drupal\ckeditorfootnotes\Plugin\CKEditorPlugin;

use Drupal\ckeditor\CKEditorPluginInterface;
use Drupal\ckeditor\CKEditorPluginButtonsInterface;
use Drupal\ckeditor\CKEditorPluginBase;
use Drupal\editor\Entity\Editor;

/**
 * Defines the "CKEditorFootnotes" plugin.
 *
 * @CKEditorPlugin(
 *   id = "footnotes",
 *   label = @Translation("CKEditorFootnotes"),
 *   module = "ckeditor"
 * )
 */
class CKEditorFootnotes extends CKEditorPluginBase implements CKEditorPluginInterface, CKEditorPluginButtonsInterface {

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getFile().
   */
  function getFile() {
    return drupal_get_path('module', 'ckeditorfootnotes') . '/js/footnotes/plugin.js';
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginButtonsInterface::getButtons().
   */
  function getButtons() {
    return array(
      'CKEditorFootnotes' => array(
        'label' => t('Footnotes'),
        'image' => drupal_get_path('module', 'ckeditorfootnotes') . '/js/footnotes/icons/footnotes.png'
      )
    );
  }

  /**
   * Implements \Drupal\ckeditor\Plugin\CKEditorPluginInterface::getConfig().
   */
  public function getConfig(Editor $editor) {
    return array();
  }
}
