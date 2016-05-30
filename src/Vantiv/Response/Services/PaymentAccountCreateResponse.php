<?php
/**
 * @file
 * Contains Vantiv\Response\Services\PaymentAccountCreateResponse.
 */

namespace Vantiv\Response\Services;

use Vantiv\Response;

class PaymentAccountCreateResponse extends Response {

  /**
   * Overrides parent getResponse() method to return the registerTokenResponse element.
   */
  function getResponse() {
    $response = parent::getResponse();
    return $response->registerTokenResponse;
  }

}
