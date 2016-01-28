<?php

/**
 * @file
 * Contains Drupal\migrate_plus\Plugin\migrate\process\TermReference.
 */

namespace Drupal\migrate_plus\Plugin\migrate\process;

use Drupal\Core\Language\Language;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\migrate\MigrateSkipRowException;

/**
 * This plugin allows source value to be converted to a term id.
 *
 * The current value is checked for an existing term and converts it to term id.
 * It can do this by ignoring case sensitivity.
 *
 * @MigrateProcessPlugin(
 *   id = "term_reference"
 * )
 */
class TermReference extends EntityLookup implements ContainerFactoryPluginInterface {

  /**
   *
   * This is a query checking the existence of some value.
   *
   * @param $value
   * The value to check.
   *
   * @param $value_type
   *The value type of the entity.
   *
   * @param $bundle_key
   * The value key of the bundle of the entity.
   *
   * @param $bundle_value
   * The value bundle of the entity
   *
   * @param $ignore_case
   *
   * @return $identifier if the entity type exist.
   */
  protected function query($value, $value_type, $bundle_key, $bundle_value, $ignore_case) {
    if (!$bundle_key && !$bundle_value) {
      throw new MigrateSkipRowException('No bundle key and value provided for taxonomy migration');
    }
    $results = $this->entityManager->getStorage($this->configuration['entity_type'])
      ->getQuery()
      ->condition($value_type, $value)
      ->condition($bundle_key, $bundle_value)
      ->execute();

    /* Returns NULL if $result don't exist. */
    if (!$results && $ignore_case) {
       return NULL;
    }
    else {
      /* Returns the entity's identifier */
      $value_lower = strtolower($value);
      $identifiers = $this->entityManager->getStorage($this->configuration['entity_type'])->loadMultiple($results);

      foreach ($identifiers as $identifier  => $key) {
        if ($value_lower == strtolower($key->label())) {
          return $identifier;
        }
      }
    }
  }

  /**
   * Generates entity for a given value.
   *
   * @param string $value
   *   Name of entity to create
   *
   * @return $id
   *   The id of the created entity.
   */
  protected function generateEntity($value) {
    $bundle = reset($this->configuration['bundle']);
    $bundle_key = key($bundle);
    $bundle_value = reset($bundle);
    $stub = array(
      'name' => $value,
      'format' => filter_fallback_format(),
      'langcode' => Language::LANGCODE_NOT_SPECIFIED,
      $bundle_key => $bundle_value,
    );
    $entity = $this->entityManager->getStorage($this->configuration['entity_type'])->create($stub);
    $entity->save();
    return $entity->id();
  }

  /**
   * Sets the entity type by default.
   */
  protected function setEntityType() {
    if (!$this->configuration['entity_type']) {
      $this->configuration['entity_type'] = 'taxonomy_term';
    }
  }
}
