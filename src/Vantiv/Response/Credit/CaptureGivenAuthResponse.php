<?php
/**
 * @file
 * Contains Vantiv\Response\CaptureGivenAuthResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class CaptureGivenAuthResponse extends Response {

  /**
   * @return stdClass The authorizationResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->authorizationResponse;
  }

}
