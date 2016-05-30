<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\CaptureGivenAuth.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\CaptureGivenAuthResponse;
use Vantiv\Request;

class CaptureGivenAuth extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('captureGivenAuth')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a CaptureGivenAuthResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new CaptureGivenAuthResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
