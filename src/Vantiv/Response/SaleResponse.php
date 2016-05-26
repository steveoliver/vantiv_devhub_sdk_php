<?php
/**
 * @file
 * Contains Vantiv\Response\SaleResponse.
 */

namespace Vantiv\Response;

use Vantiv\Response;

class SaleResponse extends Response {

  /**
   * Overrides parent get() method to return the child saleResponse element.
   */
  function get() {
    $response = parent::get();
    return $response->saleResponse;
  }

}
