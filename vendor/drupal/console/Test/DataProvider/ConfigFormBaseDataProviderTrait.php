<?php

namespace Drupal\Console\Test\DataProvider;

/**
 * Class ConfigFormBaseDataProviderTrait
 * @package Drupal\Console\Test\DataProvider
 */
trait ConfigFormBaseDataProviderTrait
{
    /**
     * @return array
     */
    public function commandData()
    {
        $this->setUpTemporalDirectory();

        return [
          ['Foo', 'foo' . rand(), 'Bar', null, null, null],
        ];
    }
}
