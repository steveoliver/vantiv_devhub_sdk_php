<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Reversal.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\ReversalResponse;
use Vantiv\Request;

class Reversal extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('reversal')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a ReversalResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new ReversalResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
