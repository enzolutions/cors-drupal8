<?php

/**
 * @file
 * Contains Drupal\cors\CorsOptionsRequest.
 */

namespace Drupal\cors;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use \Symfony\Component\HttpKernel\Event\GetResponseEvent;
use \Symfony\Component\HttpFoundation\Response;

class CORSOptionsRequest implements EventSubscriberInterface {

  static public function getSubscribedEvents() {
    return [
      'kernel.request' => 'onKernelRequest',
    ];
  }

  public function onKernelRequest(GetResponseEvent $event){
    $request = $event->getRequest();

    if ($request->getMethod() == 'OPTIONS') {
      error_log('Inside onKernelRequest ');
      $response = new Response(NULL);
      //$response->setStatusCode(200);
      $response->headers->set('Access-Control-Allow-Origin', '*');
      $response->headers->set('Access-Control-Allow-Headers', 'Authorization');
      $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PATCH, DELETE, OPTIONS');

      $event->setResponse($response);
      //$event->stopPropagation();
      return ;
    }
  }
}
