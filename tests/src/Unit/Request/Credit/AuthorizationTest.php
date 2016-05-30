<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Authorization class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Authorization;

class AuthorizationTest extends \PHPUnit_Framework_TestCase {

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
   * Tests constructed properties of Authorization request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $auth = new Authorization($config);

    $this->assertEquals($auth->getCategory(), 'payment');
    $this->assertEquals($auth->getProxy(), 'credit');
    $this->assertEquals($auth->getEndpoint(), 'authorization');
    $this->assertEquals($auth->getMethod(), 'POST');
  }

  public function testResponseObject() {
    $request = new Authorization($this->_config);
    $result = $request->send([
      'Credentials' => [],
      'Reports' => [],
      'Transaction' => [],
      'Application' => []
    ]);
    $response = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\AuthorizationResponse', $response);
  }

}
