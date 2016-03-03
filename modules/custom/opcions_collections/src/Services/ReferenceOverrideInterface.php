<?php
namespace Drupal\opcions_collections\Services;


use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\paragraphs\ParagraphInterface;

interface ReferenceOverrideInterface
{

  const HIDE = 0;
  const ORIGINAL = 1;
  const OVERRIDE = 2;
  const VIDEO_OVERLAY = 3;

  /**
   * @param ContentEntityInterface $reference
   * @param ParagraphInterface $paragraph
   * @return ContentEntityInterface
   *   The referenced entity with the overriden values
   */
  public function override(ContentEntityInterface $reference, ParagraphInterface $paragraph);

}