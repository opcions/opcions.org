<?php

/*
 * @file Drupal\Tests\opcions_subscription\Functional\NewSubscriptionFormTest
 * Contains
 */

namespace Drupal\Tests\opcions_subscription\Functional;

use Drupal\simpletest\Tests\BrowserTest;

class NewSubscriptionFormTest extends BrowserTest {

  /**
   * Test that the subscribe route works
   */
  public function testFormRoute() {
    $this->getUrl('/subscribe');
    $this->assertResponse(200);
  }
}