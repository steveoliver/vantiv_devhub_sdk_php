<?php
/**
 * @file
 * Contains Vantiv\Response\CaptureResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class CaptureResponse extends Response {

  /**
   * @return stdClass The captureResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->captureResponse;
  }

}
