<?php

namespace Drupal\opcions_collections\Hook;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\paragraphs\ParagraphInterface;

class CollectionReferenceOverrideAlter
{

  const ORIGINAL = 0;
  const OVERRIDE = 1;
  const HIDE = 2;

  /**
   * {@inheritdoc}
   */
  public function alter(array &$build, \Drupal\Core\Entity\EntityInterface $entity, \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display) {
    /* @var \Drupal\Core\Field\EntityReferenceFieldItemList */
    $reference = &$build['field_node_reference']['#items'];
    $overrides = [];
    switch ($entity->field_title_override_mode->value) {
      case self::OVERRIDE:
        //kint($build);
        $overrides['title'] = $entity->field_title_override->value;
        break;
      case self::HIDE:
        $overrides['title'] = '';
    }

    $reference->_reference_overrides = $overrides;
  }

  /**
   * @param $variables
   * @param $item
   * @param $delta
   */
  public function preprocess(&$variables, $item, $delta) {
    if (!empty($overrides = $item->_reference_overrides)) {
      foreach ($overrides as $property => $value) {
        $variables['items'][$delta]['content']['#node']->{$property} = $value;
      }
    }
  }
}