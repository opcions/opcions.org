<?php

/**
 * @file
 * Contains Drupal\Console\Command\ServicesTrait.
 */

namespace Drupal\Console\Command;

use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Output\OutputInterface;

trait ServicesTrait
{
    /**
     * @param OutputInterface $output
     * @param HelperInterface $dialog
     *
     * @return mixed
     */
    public function servicesQuestion(OutputInterface $output, HelperInterface $dialog)
    {
        if ($dialog->askConfirmation(
            $output,
            $dialog->getQuestion($this->trans('commands.common.questions.services.confirm'), 'no', '?'),
            false
        )
        ) {
            $service_collection = [];
            $output->writeln($this->trans('commands.common.questions.services.message'));

            $services = $this->getServices();
            while (true) {
                $service = $dialog->askAndValidate(
                    $output,
                    $dialog->getQuestion($this->trans('commands.common.questions.services.name'), ''),
                    function ($service) use ($services) {
                        return $this->validateServiceExist($service, $services);
                    },
                    false,
                    null,
                    $services
                );

                if (empty($service)) {
                    break;
                }

                array_push($service_collection, $service);
                $service_key = array_search($service, $services, true);

                if ($service_key >= 0) {
                    unset($services[$service_key]);
                }
            }

            return $service_collection;
        }

        return;
    }

    /**
     * @param Array $services
     *
     * @return Array
     */
    public function buildServices($services)
    {
        if (!empty($services)) {
            $build_service = [];
            foreach ($services as $service) {
                $class = get_class($this->getContainer()->get($service));
                $explode_class = explode('\\', $class);
                $build_service[$service] = [
                  'name' => $service,
                  'machine_name' => str_replace('.', '_', $service),
                  'class' => $class,
                  'short' => end($explode_class),
                ];
            }

            return $build_service;
        }

        return;
    }
}
