<?php

/**
 * @file
 * Contains \Drupal\Console\Command\MigrateDebugCommand.
 */

namespace Drupal\Console\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateDebugCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('migrate:debug')
            ->setDescription($this->trans('commands.migrate.debug.description'))
            ->addArgument(
                'tag',
                InputArgument::OPTIONAL,
                $this->trans('commands.migrate.debug.arguments.tag')
            );

        $this->addDependency('migrate');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleHandler = $this->getModuleHandler();

        $drupal_version = $input->getArgument('tag');

        $table = $this->getTableHelper();
        $table->setlayout($table::LAYOUT_COMPACT);
        $this->getAllMigrations($drupal_version, $output, $table);
    }

    protected function getAllMigrations($drupal_version, $output, $table)
    {
        $migrations = $this->getMigrations($drupal_version);

        $table->setHeaders(
            [
            $this->trans('commands.migrate.debug.messages.id'),
            $this->trans('commands.migrate.debug.messages.description'),
            $this->trans('commands.migrate.debug.messages.tags'),
            ]
        );

        $table->setlayout($table::LAYOUT_COMPACT);

        if (empty($migrations)) {
            $output->writeln(
                '[-] <error>' .
                sprintf(
                    $this->trans('commands.migrate.debug.messages.no-migrations'),
                    count($migrations)
                )
                . '</error>'
            );
        } else {
            foreach ($migrations as $migration_id => $migration) {
                $table->addRow([$migration_id, $migration['description'], $migration['tags']]);
            }
            $table->render($output);
        }
    }
}
