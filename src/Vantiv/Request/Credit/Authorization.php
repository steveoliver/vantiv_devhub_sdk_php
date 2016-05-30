<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Authorization.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\AuthorizationResponse;
use Vantiv\Request;

class Authorization extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('authorization')
      ->setMethod('POST');

  }

  /**
   * Overrides parent response to return an AuthorizationResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new AuthorizationResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
