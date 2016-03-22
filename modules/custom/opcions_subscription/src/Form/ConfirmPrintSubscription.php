<?php

namespace Drupal\opcions_subscription\Form;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Template\TwigEnvironment;
use Drupal\Core\Url;
use Drupal\user\PrivateTempStore;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ConfirmPrintSubscription extends ConfirmFormBase
{
  const ROUTE_NAME = 'view.subscriptions.page_1';

  /**
   * The temp store collection.
   *
   * @var PrivateTempStore
   */
  protected $store;

  /**
   * The entity manager.
   *
   * @var EntityStorageInterface
   */
  protected $subscriptionStorage;
  /**
   * @var TwigEnvironment
   */
  private $twig;

  /**
   * SubscriptionPrintConfirm constructor.
   * @param PrivateTempStore $private_temp_store
   * @param EntityStorageInterface $subscription_storage
   * @param TwigEnvironment $twig
   */
  public function __construct(PrivateTempStore $private_temp_store, EntityStorageInterface $subscription_storage, TwigEnvironment $twig) {
    $this->store = $private_temp_store;
    $this->subscriptionStorage = $subscription_storage;
    $this->twig = $twig;
  }

  /**
   * @param ContainerInterface $container
   * @return static
   */
  public static function create(ContainerInterface $container)
  {
    return new static(
      $container->get('user.private_tempstore')->get('opcions_print_subscription'),
      $container->get('entity_type.manager')->getStorage('subscription'),
      $container->get('twig')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'opcions_confirm_print_subscription';
  }

  public function getQuestion()
  {
    $count = count($this->store->get('subscriptions'));
    return $this->t('You are going to print @count subscriptions', ['@count', $count]);
  }


  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url(self::ROUTE_NAME);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Print');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Retrieve the accounts to be canceled from the temp store.
    $subscriptions = $this->store->get('subscriptions');
    if (empty($subscriptions)) {
      return $this->redirect(self::ROUTE_NAME);
    }

    $form['subscriptions'] = array('#prefix' => '<ul>', '#suffix' => '</ul>', '#tree' => TRUE);
    foreach ($subscriptions as $subscription) {
      /* @var $subscription \Drupal\Core\Entity\EntityInterface */
      $form['subscriptions'][$subscription->id()] = array(
        '#type' => 'hidden',
        '#value' => $subscription->id(),
        '#prefix' => '<li>',
        '#suffix' => $subscription->label() . "</li>\n",
      );
    }

    $form['template'] = array(
      '#type' => 'radios',
      '#title' => $this->t('Choose a template'),
      '#description' => t('The template you want to use to print this subscriptions'),
      '#options' => ['records' => t('Records'), 'labels' => t('Labels')],
      '#default_value' => 'records',
      '#required' => TRUE,
    );

    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {

    // Clear out the temp store.
    $this->store->delete('subscriptions');
    if ($form_state->getValue('confirm')) {
      $ids = array_keys($form_state->getValue('subscriptions'));
      $subscriptions = $this->subscriptionStorage->loadMultiple($ids);
      $display = \Drupal::entityTypeManager()->getStorage('entity_view_display')->load('subscription.subscription.default');
      $view = '';
      foreach ($subscriptions as $subscription) {

        // build view
        $view .= $this->twig->renderInline('test {{ subscription.email.value }}', ['subscription' => $subscription]);

      }
      // create pdf
      drupal_set_message($view);
      // set download headers
    }
    $form_state->setRedirect(self::ROUTE_NAME);
  }


}