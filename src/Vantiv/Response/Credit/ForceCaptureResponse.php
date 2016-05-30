<?php
/**
 * @file
 * Contains Vantiv\Response\ForceCaptureResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class ForceCaptureResponse extends Response {

  /**
   * @return stdClass The forceCaptureResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->forceCaptureResponse;
  }

}
