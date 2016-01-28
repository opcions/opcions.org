<?php
/**
 * @file
 * Contains \Drupal\opcions_migration\Event\MigrateEvent.
 */
namespace Drupal\opcions_migration\Event;

use Drupal\migrate\MigrateSkipRowException;
use Drupal\migrate_plus\Event\MigrateEvents;
use Drupal\migrate_plus\Event\MigratePrepareRowEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MigrateEvent implements EventSubscriberInterface {
    /**
     * {@inheritdoc}
     */
    static function getSubscribedEvents() {
        $events[MigrateEvents::PREPARE_ROW][] = array('onPrepareRow', 0);
        return $events;
    }
    /**
     * React to a new row.
     *
     * @param \Drupal\migrate_plus\Event\MigratePrepareRowEvent $event
     *   The prepare-row event.
     */
    public function onPrepareRow(MigratePrepareRowEvent $event) {
        $row = $event->getRow();
        if ( empty($row->getSourceProperty('category')) ) {
            throw new MigrateSkipRowException('No category set, skip row');
        }
    }
}