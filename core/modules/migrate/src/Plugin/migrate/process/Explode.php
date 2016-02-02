<?php

/**
 * @file
 * Contains \Drupal\migrate\Plugin\migrate\process\Explode.
 */

namespace Drupal\migrate\Plugin\migrate\process;

use Drupal\migrate\ProcessPluginBase;
use Drupal\migrate\MigrateException;
use Drupal\migrate\MigrateExecutableInterface;
use Drupal\migrate\Row;

/**
 * This plugin explodes a value.
 *
 * @MigrateProcessPlugin(
 *   id = "explode",
 *   handle_multiples = TRUE
 * )
 */
class Explode extends ProcessPluginBase {

  /**
   * {@inheritdoc}
   */
  public function transform($value, MigrateExecutableInterface $migrate_executable, Row $row, $destination_property) {
    if (is_string($value)) {
      if (!empty($this->configuration['delimiter'])) {
        return array_map('trim', explode($this->configuration['delimiter'], $value));
      }
      else {
        throw new MigrateException('delimiter is empty');
      }
    }
    else {
      throw new MigrateException(sprintf('%s is not a string', var_export($value, TRUE)));
    }
  }

  public function multiple()
  {
    return TRUE;
  }

}
