<?php
/**
 * @file
 * Contains Vantiv\Response\AuthorizationResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class AuthorizationResponse extends Response {

  /**
   * @return stdClass The authorizationResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->authorizationResponse;
  }

}
