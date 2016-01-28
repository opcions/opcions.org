<?php

/**
 * @file
 * Contains Drupal\migrate_plus\Plugin\migrate\process\EntityLookup.
 */

namespace Drupal\migrate_plus\Plugin\migrate\process;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\migrate\Entity\MigrationInterface;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\Row;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class EntityLookup
 * @package Drupal\migrate_plus\Plugin\migrate\process
 */
abstract class EntityLookup extends ProcessPluginBase {

  /** @var \Drupal\Core\Entity\EntityTypeManagerInterface */
  protected $entityManager;

  /** @var \Drupal\migrate\Entity\MigrationInterface */
  protected $migration;

  /**
   * {@inheritdoc}
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration, EntityTypeManagerInterface $entity_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->migration = $migration;
    $this->entityManager = $entity_manager;
    $this->setEntityType();
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition, MigrationInterface $migration = NULL) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $migration,
      $container->get('entity.manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (!isset($this->configuration['entity_type']) || !is_string($this->configuration['entity_type'])) {
      throw new MigrateException(sprintf('The entity_lookup plugin requires a "entity_type" configuration setting which should be a string, such as "node". Configuration is: %s', var_export($configuration, TRUE)));
    }
    if (!isset($this->configuration['value_type']) || !is_string($this->configuration['value_type'])) {
      throw new MigrateException(sprintf('The entity_lookup plugin requires a "value_type" configuration setting which should be a string that represents a entity property or field name to search on, such as "title". Configuration is: %s', var_export($configuration, TRUE)));
    }
    $ignore_case = isset($this->configuration['ignore_case']) ?: TRUE;

    $value_type = $this->configuration['value_type'];
    if (isset($this->configuration['bundle']) && is_array($this->configuration['bundle'])) {
      $bundle = reset($this->configuration['bundle']);
      $bundle_key = key($bundle);
      $bundle_value = reset($bundle);
    }
    else {
      $bundle_key = $bundle_value = NULL;
    }
    // Creates a entity if the query returns NULL.
    if (!empty($value) && !$this->query($value, $value_type, $bundle_key, $bundle_value, $ignore_case)) {
      return $this->generateEntity($value);
    }
  }

  /**
   * Sets the entity type by default.
   */
abstract protected function setEntityType();

  /**
   * Generates entity for a given value.
   *
   * @param string $value
   *   Value of entity to create
   *
   * @return $id
   *   The id of the created entity.
   */
abstract protected function generateEntity($value);

  /**
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
abstract protected function query($value, $value_type, $bundle_key, $bundle_value, $ignore_case);

}
