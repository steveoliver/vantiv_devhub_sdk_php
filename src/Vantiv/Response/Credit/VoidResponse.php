<?php
/**
 * @file
 * Contains Vantiv\Response\VoidResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class VoidResponse extends Response {

  /**
   * @return stdClass The voidResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->voidResponse;
  }

}
