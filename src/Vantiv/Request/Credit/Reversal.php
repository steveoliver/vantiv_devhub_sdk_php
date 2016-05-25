<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Reversal.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class Reversal extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('reversal')
      ->setMethod('POST');
  }

}
