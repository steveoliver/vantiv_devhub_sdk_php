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
      'base_url' => 'https://cert.apis.vantiv.com',
      'license' => 'AAA'
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

}
