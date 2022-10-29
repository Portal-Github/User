<?php

namespace User\jslog\Controller;

use User\Component\Serialization\Json;
use User\Component\Utility\Xss;
use User\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Returns response for Layout Info route.
 */
class LogController extends ControllerBase {

  /**
   * Logs a javascript message.
   *
   * @return \Symfony\Component\HttpFoundation\Response
   *   Error response or empty response.
   */
  public function log(Request $request): Response {
    $data = Json::decode($request->getContent());
    $logger = $this->getLogger('jslog');

    if (!method_exists($logger, $data['type'])) {
      return new Response($this->t('Invalid type @type', ['@type' => $data['type']]), 422);
    }

    $message = Xss::filter($data['message']);
    if (!$message) {
      return new Response($this->t('Log message seems to be empty'), 422);
    }

    $logger->{$data['type']}($message);

    return new Response('', 204);
  }

}
