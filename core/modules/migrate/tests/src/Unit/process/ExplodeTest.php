<?php

/**
 * @file
 * Contains \Drupal\Tests\migrate\Unit\process\ExplodeTest.
 */

namespace Drupal\Tests\migrate\Unit\process;

use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\migrate\Plugin\MigrateProcessInterface;
use Drupal\migrate\Plugin\migrate\process\Explode;
use Drupal\Tests\migrate\Unit\process\MigrateProcessTestCase;

/**
 * Tests the Explode process plugin.
 *
 * @group migrate
 */
class ExplodeTest extends MigrateProcessTestCase {

  /**
   * The module handler.
   *
   * @var \Drupal\Core\Extension\ModuleHandlerInterface
   */
  protected $moduleHandler;

  /**
   * The migration plugin.
   *
   * @var \Drupal\migrate\Plugin\MigrateProcessInterface
   */
  protected $migrationPlugin;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    $this->moduleHandler = $this->prophesize(ModuleHandlerInterface::class);
    $this->migrationPlugin = $this->prophesize(MigrateProcessInterface::class);
    parent::setUp();
  }

  /**
   * Tests the transform process.
   */
  public function testTransform() {
    $configuration['delimiter'] = '_';
    $this->plugin = new Explode($configuration, 'explode', [], $this->moduleHandler->reveal(), $this->migrationPlugin->reveal());
    $source = 'color_bartik_stylesheets';
    $result = ['color', 'bartik', 'stylesheets'];
    $transformed_value = $this->plugin->transform($source, $this->migrateExecutable, $this->row, 'destinationproperty');
    $this->assertSame($result, $transformed_value);
  }

  /**
   * Tests invalid input.
   *
   * @expectedException \Drupal\migrate\MigrateException
   * @expectedExceptionMessage is not a string
   */
  public function testSourceString() {
    $configuration['delimiter'] = '_';
    $this->plugin = new Explode($configuration, 'explode', [], $this->moduleHandler->reveal(), $this->migrationPlugin->reveal());
    $this->plugin->transform(['color_bartik_stylesheets'], $this->migrateExecutable, $this->row, 'destinationproperty');
  }

  /**
   * Tests empty delimiter.
   *
   * @expectedException \Drupal\migrate\MigrateException
   * @expectedExceptionMessage delimiter is empty
   */
  public function testDelimiterEmpty() {
    $configuration['delimiter'] = '';
    $this->plugin = new Explode($configuration, 'explode', [], $this->moduleHandler->reveal(), $this->migrationPlugin->reveal());
    $this->plugin->transform('color_bartik_stylesheets', $this->migrateExecutable, $this->row, 'destinationproperty');
  }

}
