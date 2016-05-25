<?php
/**
 * @file
 * Unit tests for the Vantiv\Request class.
 */

namespace Vantiv\Test\Unit;

use Vantiv\Configuration;
use Vantiv\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {

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
   * Tests that a URI is constructed by calling setTransactionType().
   */
  public function testTransactionType() {
    $config = $this->_config;
    $request = new Request($config);

    $request->setTransactionType('payment', 'credit', 'authorization', 'POST', ['val' => 'test']);

    $this->assertEquals($request->getCategory(), 'payment');
    $this->assertEquals($request->getProxy(), 'credit');
    $this->assertEquals($request->getEndpoint(), 'authorization');
    $this->assertEquals($request->getMethod(), 'POST');
    $this->assertEquals($request->getQuery()['val'], 'test');

    $request->constructUri();
    $expected_uri = $config->base_url . '/payment/sp2/credit/v' . $config->api_version . '/authorization';
    $this->assertEquals($request->getUri(), $expected_uri);
  }

  public function testQueryStringGet() {
    $config = $this->_config;
    $request = new Request($config);

    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', ['val' => 'test', 'foo' => 'bar']);

    $this->assertEquals($request->getCategory(), 'payment');
    $this->assertEquals($request->getProxy(), 'credit');
    $this->assertEquals($request->getEndpoint(), 'authorization');
    $this->assertEquals($request->getMethod(), 'GET');
    $this->assertEquals($request->getQuery()['val'], 'test');

    $request->constructUri();
    $expected_uri = $config->base_url . '/payment/sp2/credit/v' . $config->api_version . '/authorization?val=test&foo=bar';
    $this->assertEquals($request->getUri(), $expected_uri);
  }

  public function testSendGet() {
    $request = new Request($this->_config);

    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', []);

    $result = $request->send([]);
    $this->assertEquals($result['response'], FALSE);
    $this->assertEquals($result['http_code'], 0);
  }

  public function testSendPost() {
    $request = new Request($this->_config);

    $result = $request->send([], 'payment', 'credit', 'sale', 'POST', []);
    $this->assertEquals($result['response'], FALSE);
    $this->assertEquals($result['http_code'], 0);
  }

}
