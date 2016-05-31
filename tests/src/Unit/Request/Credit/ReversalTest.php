<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Reversal class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Reversal;

class ReversalTest extends \PHPUnit_Framework_TestCase {

  /** @var Configuration */
  protected $_config = NULL;

  protected function setUp() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'https://apis.cert.vantiv.com',
      'license' => 'AAA'
    ]);
  }

  /**
   * Tests constructed properties of Reversal request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $auth = new Reversal($config);

    $this->assertEquals($auth->getCategory(), 'payment');
    $this->assertEquals($auth->getProxy(), 'credit');
    $this->assertEquals($auth->getEndpoint(), 'reversal');
    $this->assertEquals($auth->getMethod(), 'POST');
  }

  public function testResponseObject() {
    $request = new Reversal($this->_config);
    $result = $request->send([
      'Credentials' => [ ],
      'Reports' => [ ],
      'Transaction' => [ ],
      'Application' => [ ]
    ]);
    $response = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\Credit\ReversalResponse', $response);
  }

}
