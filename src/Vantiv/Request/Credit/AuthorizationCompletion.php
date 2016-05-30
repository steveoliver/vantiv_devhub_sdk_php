<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\AuthorizationCompletion.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\CaptureResponse;
use Vantiv\Request;

class AuthorizationCompletion extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('authorizationCompletion')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a CaptureResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new CaptureResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
