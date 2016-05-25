<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Authorization.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class Authorization extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('authorization')
      ->setMethod('POST');
  }

}
