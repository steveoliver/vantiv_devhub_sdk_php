<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Credit.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class Credit extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('credit')
      ->setMethod('POST');
  }

}