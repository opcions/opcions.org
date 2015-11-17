<?php

namespace Drupal\Console\Test\DataProvider;

/**
 * Class EntityContentDataProviderTrait
 * @package Drupal\Console\Test\DataProvider
 */
trait EntityContentDataProviderTrait
{
    /**
     * @return array
     */
    public function commandData()
    {
        $this->setUpTemporalDirectory();

        return [
          ['Foo', 'foo' . rand(), 'Bar', 'bar'],
        ];
    }
}
