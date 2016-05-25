<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Credit class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Credit;

class CreditTest extends \PHPUnit_Framework_TestCase {

  /** @var Configuration */
  protected $_config = NULL;

  protected function setUp() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'https://cert.apis.vantiv.com',
      'license' => 'AAA'
    ]);
  }

  /**
   * Tests constructed properties of Credit request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $auth = new Credit($config);

    $this->assertEquals($auth->getCategory(), 'payment');
    $this->assertEquals($auth->getProxy(), 'credit');
    $this->assertEquals($auth->getEndpoint(), 'credit');
    $this->assertEquals($auth->getMethod(), 'POST');
  }

}