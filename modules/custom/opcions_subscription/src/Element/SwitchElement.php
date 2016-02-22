<?php
/**
 * @file
 * Contains \Drupal\theme_example\Element\MyElement.
 */

namespace Drupal\opcions_subscription\Element;

use Drupal\Core\Render\Element\Checkbox;

/**
 * Provides an switch element.
 *
 * @RenderElement("switch")
 */
class SwitchElement extends Checkbox
{
  /**
   * {@inheritdoc}
   */
  public function getInfo()
  {
    $render = parent::getInfo();

    $render['#theme'] = 'input__switch';

    return $render;
  }
}