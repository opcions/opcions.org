<?php

/*
 * @file Drupal\Tests\opcions_subscription\Functional\NewSubscriptionFormTest
 * Contains
 */

namespace Drupal\opcions_subscription\Tests;

use Drupal\simpletest\BrowserTestBase;

/*
 * @group opcions
 *
 * @runTestsInSeparateProcesses
 * @preserveGlobalState disabled
 */
class NewSubscriptionFormTest extends BrowserTestBase {

  /**
   * Test that the subscribe route works
   */
  public function testFormRoute() {
    $this->drupalGet('/subscribe');
    $this->assertResponse(200);
  }
}
