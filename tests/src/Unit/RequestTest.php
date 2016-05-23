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

    $this->assertEquals($request->getCategory(), 'payment');
    $this->assertEquals($request->getProxy(), 'credit');
    $this->assertEquals($request->getEndpoint(), 'authorization');
    $this->assertEquals($request->getMethod(), 'POST');
    $this->assertEquals($request->getQuery()['val'], 'test');

    $request->constructUri();
    $expected_uri = $config['base_url'] . '/payment/sp2/credit/v' . $config['api_version'] . '/authorization';
    $this->assertEquals($request->getUri(), $expected_uri);
  }

  public function testQueryStringGet() {
    $config = [
      'api_version' => '1',
      'base_url' => 'https://cert.apis.vantiv.com',
      'license' => 'AAA'
    ];
    $request = new Request($config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', ['val' => 'test', 'foo' => 'bar']);

    $this->assertEquals($request->getCategory(), 'payment');
    $this->assertEquals($request->getProxy(), 'credit');
    $this->assertEquals($request->getEndpoint(), 'authorization');
    $this->assertEquals($request->getMethod(), 'GET');
    $this->assertEquals($request->getQuery()['val'], 'test');

    $request->constructUri();
    $expected_uri = $config['base_url'] . '/payment/sp2/credit/v' . $config['api_version'] . '/authorization?val=test&foo=bar';
    $this->assertEquals($request->getUri(), $expected_uri);
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
