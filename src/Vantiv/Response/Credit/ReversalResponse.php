<?php
/**
 * @file
 * Contains Vantiv\Response\ReversalResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class ReversalResponse extends Response {

  /**
   * @return stdClass The authReversalResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->authReversalResponse;
  }

}
