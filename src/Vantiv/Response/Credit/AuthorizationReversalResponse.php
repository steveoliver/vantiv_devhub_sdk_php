<?php
/**
 * @file
 * Contains Vantiv\Response\AuthReversalResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class AuthorizationReversalResponse extends Response {

  /**
   * @return stdClass The authReversalResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->authReversalResponse;
  }

}
