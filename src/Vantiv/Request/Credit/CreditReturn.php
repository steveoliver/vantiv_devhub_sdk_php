<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\CreditReturn.
 *
 * Class not 'Return' as return is a reserved keyword in PHP.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\CreditReturnResponse;
use Vantiv\Request;

class CreditReturn extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('return')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a CreditReturnResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new CreditReturnResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
