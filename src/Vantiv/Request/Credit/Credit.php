<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Credit.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\CreditResponse;
use Vantiv\Request;

class Credit extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('credit')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a CreditResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new CreditResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
