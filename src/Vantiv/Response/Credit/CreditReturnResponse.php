<?php
/**
 * @file
 * Contains Vantiv\Response\CreditReturnResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class CreditReturnResponse extends Response {

  /**
   * @return stdClass The creditResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->creditResponse;
  }

}
