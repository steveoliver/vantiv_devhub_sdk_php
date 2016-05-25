<?php
/**
 * @file
 * Contains Vantiv\Request\Credit\AuthorizationCompletion.
 */

namespace Vantiv\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request;

class AuthorizationCompletion extends Request {

  function __construct(Configuration $config) {
    parent::__construct($config);

    $this
      ->setCategory('payment')
      ->setProxy('credit')
      ->setEndpoint('authorizationCompletion')
      ->setMethod('POST');
  }

}
