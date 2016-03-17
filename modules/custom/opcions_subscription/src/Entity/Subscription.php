<?php

/**
 * @file
 * Contains \Drupal\opcions_subscription\Entity\Subscription.
 */

namespace Drupal\opcions_subscription\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeFieldItemList;
use Drupal\opcions_subscription\SubscriptionInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Subscription entity.
 *
 * @ingroup opcions_subscription
 *
 * @ContentEntityType(
 *   id = "subscription",
 *   label = @Translation("Subscription"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\opcions_subscription\SubscriptionListBuilder",
 *     "views_data" = "Drupal\opcions_subscription\Entity\SubscriptionViewsData",
 *
 *     "form" = {
 *       "default" = "Drupal\opcions_subscription\Form\SubscriptionForm",
 *       "add" = "Drupal\opcions_subscription\Form\SubscriptionForm",
 *       "edit" = "Drupal\opcions_subscription\Form\SubscriptionForm",
 *       "delete" = "Drupal\opcions_subscription\Form\SubscriptionDeleteForm",
 *     },
 *     "access" = "Drupal\opcions_subscription\SubscriptionAccessControlHandler",
 *     "route_provider" = {
 *       "html" = "Drupal\opcions_subscription\SubscriptionHtmlRouteProvider",
 *     },
 *   },
 *   base_table = "subscription",
 *   admin_permission = "administer subscription entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "email",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "status" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/config/opcions/subscription/{subscription}",
 *     "add-form" = "/admin/config/opcions/subscription/add",
 *     "edit-form" = "/admin/config/opcions/subscription/{subscription}/edit",
 *     "delete-form" = "/admin/config/opcions/subscription/{subscription}/delete",
 *     "collection" = "/admin/config/opcions/subscription",
 *   },
 *   field_ui_base_route = "subscription.settings"
 * )
 */
class Subscription extends ContentEntityBase implements SubscriptionInterface {
  use EntityChangedTrait;
  /**
   * {@inheritdoc}
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += array(

    );
  }

  /**
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }

  /**
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public function isActive() {
    return (bool) $this->getEntityKey('active');
  }

  /**
   * {@inheritdoc}
   */
  public function setStatus($status = self::STATUS_NEW) {
    $this->set('status', $status);
    return $this;
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Subscription entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Subscription entity.'))
      ->setReadOnly(TRUE);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User'))
      ->setDescription(t('The user ID of the subscriber.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default')
      ->setDefaultValue([])
      ->setDisplayOptions('view', array(
        'label' => 'hidden',
        'type' => 'author',
        'weight' => 0,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => array(
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => '',
        ),
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['email'] = BaseFieldDefinition::create('email')
      ->setLabel(t('Email'))
      ->setDescription(t('The email used when creating the subscription'))
      ->setDefaultValue('')
      ->setDisplayOptions('view', array(
        'label' => 'above',
        'type' => 'string',
        'weight' => -4,
      ))
      ->setDisplayOptions('form', array(
        'type' => 'string_textfield',
        'weight' => -4,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['price'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('Price'))
      ->setDescription(t('The yearly price for the subscription'))
      ->setDefaultValue('')
      ->setRevisionable(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['paper_version'] = BaseFieldDefinition::create('boolean')
      ->setLabel(t('Wants paper version'))
      ->setDefaultValue(TRUE)
      ->setRevisionable(TRUE)
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['status'] = BaseFieldDefinition::create('list_integer')
      ->setLabel(t('Subscription status'))
      ->setDescription(t('A subscriptions status.'))
      ->setDefaultValue(self::STATUS_NEW)
      ->setRequired(TRUE)
      ->setRevisionable(TRUE)
      ->setSetting('allowed_values', self::getStatusOptions())
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['langcode'] = BaseFieldDefinition::create('language')
      ->setLabel(t('Language code'))
      ->setDescription(t('The language code for the Subscription entity.'))
      ->setDisplayOptions('form', array(
        'type' => 'language_select',
        'weight' => 10,
      ))
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['experies_on'] = BaseFieldDefinition::create('datetime')
      ->setLabel(t('Expires on'))
      ->setDescription(t('Date when the subscription will expire.'))
      ->setDefaultValue([
        'default_date_type' => DateTimeFieldItemList::DEFAULT_VALUE_CUSTOM,
        'default_date' => '+1 year'
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'));

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last edited.'));

    return $fields;
  }

  public static function getStatusOptions() {
    return [
      self::STATUS_NEW => t('New (abandoned)'),
      self::STATUS_ACTIVE => t('Active'),
      self::STATUS_EXPIRED => t('Expired'),
      self::STATUS_ARCHIVED => t('Archived'),
      self::STATUS_UNSUBSCRIBED => t('Unsubscribed'),
      self::STATUS_PENDING_PAYMENT => t('Pending Payment'),
      self::STATUS_PENDING_RENEWAL => t('Pending Renewal'),
    ];
  }

  /* @todo: remove after development */
  public static function deleteAll() {
    foreach(self::loadMultiple() as $entity) {
      $entity->delete();
    }
  }
}
