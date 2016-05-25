<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Return class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\CreditReturn;

class ReturnTest extends \PHPUnit_Framework_TestCase {

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
   * Tests constructed properties of Return request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $auth = new CreditReturn($config);

    $this->assertEquals($auth->getCategory(), 'payment');
    $this->assertEquals($auth->getProxy(), 'credit');
    $this->assertEquals($auth->getEndpoint(), 'return');
    $this->assertEquals($auth->getMethod(), 'POST');
  }

}
