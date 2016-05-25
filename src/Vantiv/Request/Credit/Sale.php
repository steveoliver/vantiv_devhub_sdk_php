<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Sale.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class Sale extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('sale')
      ->setMethod('POST');
  }

}
