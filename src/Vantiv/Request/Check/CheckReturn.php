<?php
/**
 * @file
 * Contains Vantiv\Request\Check\CheckReturn.
 */

namespace Vantiv\Request\Check;

use Vantiv\Configuration;
use Vantiv\Response\Check\ReturnResponse;
use Vantiv\Request;

class CheckReturn extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('check')
      ->setEndpoint('sale')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a CheckSaleResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new ReturnResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
