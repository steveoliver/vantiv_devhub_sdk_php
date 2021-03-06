<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Force.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Response\Credit\ForceCaptureResponse;
use Vantiv\Request;

class Force extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('force')
      ->setMethod('POST');
  }

  /**
   * Overrides parent response to return a ForceCaptureResponse object.
   *
   * @param $response
   *
   * @return array
   */
  protected function response(array $response) {
    return [
      'response' => new ForceCaptureResponse($response['response']),
      'http_code' => $response['http_code']
    ];
  }

}
