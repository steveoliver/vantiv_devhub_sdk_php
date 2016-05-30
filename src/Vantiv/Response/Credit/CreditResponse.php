<?php
/**
 * @file
 * Contains Vantiv\Response\CreditResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class CreditResponse extends Response {

  /**
   * @return stdClass The creditResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->creditResponse;
  }

}
