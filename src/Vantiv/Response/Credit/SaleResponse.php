<?php
/**
 * @file
 * Contains Vantiv\Response\SaleResponse.
 */

namespace Vantiv\Response\Credit;

use Vantiv\Response;

class SaleResponse extends Response {

  /**
   * @return stdClass The saleResponse element from a Vantiv response.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->saleResponse;
  }

}
