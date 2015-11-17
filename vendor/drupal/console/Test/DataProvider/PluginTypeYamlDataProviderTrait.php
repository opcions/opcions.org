<?php

namespace Drupal\Console\Test\DataProvider;

/**
 * Class PluginTypeYamlDataProviderTrait
 * @package Drupal\Console\Test\DataProvider
 */
trait PluginTypeYamlDataProviderTrait
{
    /**
     * @return array
     */
    public function commandData()
    {
        $this->setUpTemporalDirectory();

        return [
          ['Foo', 'MyPlugin', 'my_plugin', 'my.plugin'],
        ];
    }
}
