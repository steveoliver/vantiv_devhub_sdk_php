<?php
/**
 * @file
 * Contains Vantiv\Response\Check\SaleResponse.
 */

namespace Vantiv\Response\Check;

use Vantiv\Response;

class SaleResponse extends Response {

  /**
   * @return stdClass The echeckSalesResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->echeckSalesResponse;
  }

}
