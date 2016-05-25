<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\Force.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class Force extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('force')
      ->setMethod('POST');
  }

}
