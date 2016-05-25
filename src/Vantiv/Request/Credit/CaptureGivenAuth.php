<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\CaptureGivenAuth.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class CaptureGivenAuth extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('captureGivenAuth')
      ->setMethod('POST');
  }

}
