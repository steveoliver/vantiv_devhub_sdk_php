<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Void.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\VoidResponse;
use Vantiv\Request;

class Void extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('void')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a VoidResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new VoidResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
