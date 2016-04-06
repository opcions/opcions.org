<?php

namespace Drupal\opcions_collections\Hook;


class CollectionReferenceAsQuoteAlter
{
  /**
   * {@inheritdoc}
   */
  public function alter(array &$build, \Drupal\Core\Entity\EntityInterface $entity, \Drupal\Core\Entity\Display\EntityViewDisplayInterface $display) {
    /* @var \Drupal\Core\Field\EntityReferenceFieldItemList */
    $reference = &$build['field_node_reference']['#items'];

    $overrides['#title'] = $entity->field_quote->value;

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
        $variables['items'][$delta]['content'][$property] = $value;
      }
    }
  }
}