<?php

/**
 * @file
 * Contains \Drupal\cors\Authentication\Provider\BasicAuth.
 */

namespace Drupal\cors\Authentication\Provider;

use Drupal\Core\Session\AnonymousUserSession;

use \Drupal\Component\Utility\String;
use Drupal\Core\Authentication\AuthenticationProviderInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityManagerInterface;
use Drupal\Core\Flood\FloodInterface;
use Drupal\user\UserAuthInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * HTTP Basic authentication provider.
 */
class CORSAuth implements AuthenticationProviderInterface {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * The user auth service.
   *
   * @var \Drupal\user\UserAuthInterface
   */
  protected $userAuth;

  /**
   * The flood service.
   *
   * @var \Drupal\Core\Flood\FloodInterface
   */
  protected $flood;

  /**
   * The entity manager.
   *
   * @var \Drupal\Core\Entity\EntityManagerInterface
   */
  protected $entityManager;

  /**
   * Constructs a HTTP basic authentication provider object.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\user\UserAuthInterface $user_auth
   *   The user authentication service.
   * @param \Drupal\Core\Flood\FloodInterface $flood
   *   The flood service.
   * @param \Drupal\Core\Entity\EntityManagerInterface $entity_manager
   *   The entity manager service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, UserAuthInterface $user_auth, FloodInterface $flood, EntityManagerInterface $entity_manager) {
    $this->configFactory = $config_factory;
    $this->userAuth = $user_auth;
    $this->flood = $flood;
    $this->entityManager = $entity_manager;
  }

  /**
   * {@inheritdoc}
   */
  public function applies(Request $request) {

    if ($request->getMethod() == 'OPTIONS') {
      return TRUE;
    }
    else {
      return FALSE;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function authenticate(Request $request) {
    error_log('Inside Cors Auth ');
    return new AnonymousUserSession();;
  }

  /**
   * {@inheritdoc}
   */
  public function cleanup(Request $request) {}

  /**
   * {@inheritdoc}
   */
  public function handleException(GetResponseForExceptionEvent $event) {
    return FALSE;
  }

}
