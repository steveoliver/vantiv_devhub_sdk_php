<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\CaptureGivenAuth class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\CaptureGivenAuth;

class CaptureGivenAuthTest extends \PHPUnit_Framework_TestCase {

  /** @var Configuration */
  protected $_config = NULL;

  protected function setUp() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'https://apis.cert.vantiv.com',
      'license' => getenv('VANTIV_DEVHUB_LICENSE') ?: 'AAA'
    ]);
  }

  /**
   * Tests constructed properties of CaptureGivenAuth request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $request = new CaptureGivenAuth($config);

    $this->assertEquals($request->getCategory(), 'payment');
    $this->assertEquals($request->getProxy(), 'credit');
    $this->assertEquals($request->getEndpoint(), 'captureGivenAuth');
    $this->assertEquals($request->getMethod(), 'POST');
  }

  public function testResponseObject() {
    $request = new CaptureGivenAuth($this->_config);
    $result = $request->send([
      'Credentials' => [],
      'Reports' => [],
      'Transaction' => [],
      'Application' => []
    ]);
    $response = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\Credit\CaptureGivenAuthResponse', $response);
  }

}
