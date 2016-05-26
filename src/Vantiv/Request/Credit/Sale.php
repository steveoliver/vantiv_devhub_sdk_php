<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Sale.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;
use Vantiv\Response\SaleResponse;

class Sale extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('sale')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to send response as a SaleResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new SaleResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
