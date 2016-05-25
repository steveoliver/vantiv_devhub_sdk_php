<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\CreditReturn.
 *
 * Class not 'Return' as return is a reserved keyword in PHP.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class CreditReturn extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('return')
      ->setMethod('POST');
  }

}
