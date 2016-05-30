<?php
/**
 * @file
 * Contains Vantiv\Request\Services\PaymentAccountCreate.
 */

namespace Vantiv\Request\Services;

use Vantiv\Configuration;
use Vantiv\Response\Services\PaymentAccountCreateResponse;
use Vantiv\Request;

class PaymentAccountCreate extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('services')
      ->setEndpoint('paymentAccountCreate')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a PaymentAccountCreateResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new PaymentAccountCreateResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
