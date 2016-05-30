<?php
/**
 * @file
 * Contains Vantiv\Response\Check\ReturnResponse.
 */

namespace Vantiv\Response\Check;

use Vantiv\Response;

class ReturnResponse extends Response {

  /**
   * @return stdClass The echeckCreditResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->echeckCreditResponse;
  }

}
