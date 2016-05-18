<?php
/**
 * @file
 * Unit tests for the Vantiv\Request class.
 */

namespace Vantiv\Test\Unit;

use Vantiv\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {

  /**
   * Tests that a URI is constructed by calling setTransactionType().
   */
  public function testTransactionType() {
    $config = [
      'api_version' => '1',
      'base_url' => 'https://cert.apis.vantiv.com',
      'license' => 'AAA'
    ];
    $request = new Request($config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'POST', ['val' => 'test']);

    $this->assertEquals($request->category, 'payment');
    $this->assertEquals($request->proxy, 'credit');
    $this->assertEquals($request->endpoint, 'authorization');
    $this->assertEquals($request->method, 'POST');
    $this->assertEquals($request->query['val'], 'test');

    $request->constructUri();
    $expected_uri = $config['base_url'] . '/payment/sp2/credit/v' . $config['api_version'] . '/authorization';
    $this->assertEquals($request->uri, $expected_uri);
  }

  public function testQueryStringGet() {
    $config = [
      'api_version' => '1',
      'base_url' => 'https://cert.apis.vantiv.com',
      'license' => 'AAA'
    ];
    $request = new Request($config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', ['val' => 'test', 'foo' => 'bar']);

    $this->assertEquals($request->category, 'payment');
    $this->assertEquals($request->proxy, 'credit');
    $this->assertEquals($request->endpoint, 'authorization');
    $this->assertEquals($request->method, 'GET');
    $this->assertEquals($request->query['val'], 'test');

    $request->constructUri();
    $expected_uri = $config['base_url'] . '/payment/sp2/credit/v' . $config['api_version'] . '/authorization?val=test&foo=bar';
    $this->assertEquals($request->uri, $expected_uri);
  }

  /**
   * @expectedException Exception
   */
  public function testMissingApiVersion() {
    $request = new Request([
      'license' => 'BBB',
      'base_url' => 'https://localhost'
    ]);
  }

  /**
   * @expectedException Exception
   */
  public function testMissingBaseUrl() {
    $request = new Request([
      'api_version' => 1,
      'license' => 'BBB'
    ]);
  }

  /**
   * @expectedException Exception
   */
  public function testMissingLicense() {
    $request = new Request([
      'api_version' => 1,
      'base_url' => 'https://localhost'
    ]);
  }

}
