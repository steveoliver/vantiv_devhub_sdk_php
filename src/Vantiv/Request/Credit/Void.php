<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Void.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class Void extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('void')
      ->setMethod('POST');
  }

}
