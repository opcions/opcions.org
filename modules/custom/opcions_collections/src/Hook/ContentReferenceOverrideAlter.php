<?php
namespace Drupal\opcions_collections\Hook;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\paragraphs\ParagraphInterface;

class ContentReferenceOverrideAlter
{

  /**
   * {@inheritdoc}
   */
  public function override(ContentEntityInterface $reference, ParagraphInterface $paragraph) {

      switch ($paragraph->field_title_override_mode->value) {
        case self::HIDE:
          $reference->setTitle('');
          break;
        case self::OVERRIDE:
          $reference->setTitle($paragraph->field_title_override->value);
          break;
      }

    return $reference;

  }
}