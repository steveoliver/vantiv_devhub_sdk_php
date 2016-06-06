<?php
/**
 * @file
 * Unit tests for the Vantiv\Request class.
 */

namespace Vantiv\Test\Unit;

use Exception;
use Vantiv\Configuration;
use Vantiv\Request;

class RequestTest extends \PHPUnit_Framework_TestCase {

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

  /**
   * Tests that a query ends up in the URI of a GET Request.
   */
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

  /**
   * @expectedException Exception
   * @expectedExceptionMessage Required params Credentials.AcceptorID are missing from request.
   */
  public function testMissingRequiredGlobalParams() {
    $request = new Request($this->_config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', []);
    $request->send([
      'Credentials' => [
        'AcceptorID' => ''
      ],
      'Reports' => [
        'ReportGroup' => '1243'
      ],
      'Transaction' => [
        'ReferenceNumber' => '1',
        'TransactionAmount' => '101.00',
        'OrderSource' => 'ecommerce',
        'CustomerID' => '1'
      ],
      'Application' => [
        'ApplicationID' => 's12341'
      ]
    ]);
  }

  /**
   * @expectedException Exception
   * @expectedExceptionMessage Credentials, Reports, Transaction, Application keys are missing from request.
   */
  public function testMissingAllRequiredElements() {
    $request = new Request($this->_config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', []);
    $request->send([]);
  }

  /**
   * @expectedException Exception
   * @expectedExceptionMessage Credentials, Reports keys are missing from request.
   */
  public function testMissingSomeRequiredElements() {
    $request = new Request($this->_config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', []);
    $request->send([
      'Transaction' => [],
      'Application' => []
    ]);
  }

  /**
   * Tests Request::send() with a GET method (where query is in URL, not body).
   */
  public function testSendGet() {
    $request = new Request($this->_config);
    $request->setTransactionType('payment', 'credit', 'authorization', 'GET', []);
    $result = $request->send([
      'Credentials' => [
        'AcceptorID' => '1147003'
      ],
      'Reports' => [
        'ReportGroup' => '1243'
      ],
      'Transaction' => [
        'ReferenceNumber' => '1',
        'TransactionAmount' => '101.00',
        'OrderSource' => 'ecommerce',
        'CustomerID' => '1'
      ],
      'Application' => [
        'ApplicationID' => 's12341'
      ]
    ]);
    $this->assertInstanceOf('Vantiv\Response', $result['response']);
    $this->assertTrue($result['http_code'] >= 200);
  }

  /**
   * Tests that a direct Request::send() with more than body sets the Tx type.
   */
  public function testDirectSendSetsTransactionType() {
    $request = new Request($this->_config);
    $request->send([
      'Credentials' => [
        'AcceptorID' => '1147003'
      ],
      'Reports' => [
        'ReportGroup' => '1243'
      ],
      'Transaction' => [
        'ReferenceNumber' => '1',
        'TransactionAmount' => '101.00',
        'OrderSource' => 'ecommerce',
        'CustomerID' => '1'
      ],
      'Application' => [
        'ApplicationID' => 's12341'
      ]
    ], 'payment', 'credit', 'sale', 'POST', ['foo' => 'bar']);
    $this->assertEquals($request->getCategory(), 'payment');
    $this->assertEquals($request->getProxy(), 'credit');
    $this->assertEquals($request->getEndpoint(), 'sale');
  }

  /**
   * Tests that a direct Request returns a parent Vantiv\Response object.
   */
  public function testDirectRequestResponse() {
    $request = new Request($this->_config);
    $request->setTransactionType('payment', 'credit', 'sale', 'POST', ['foo' => 'bar']);
    $result = $request->send([
      'Credentials' => [
        'AcceptorID' => '1147003'
      ],
      'Reports' => [
        'ReportGroup' => '1243'
      ],
      'Transaction' => [
        'ReferenceNumber' => '1',
        'TransactionAmount' => '101.00',
        'OrderSource' => 'ecommerce',
        'CustomerID' => '1'
      ],
      'Application' => [
        'ApplicationID' => 's12341'
      ]
    ]);
    $this->assertTrue($result['http_code'] >= 200);
    $this->assertInstanceOf('Vantiv\Response', $result['response']);
  }

}
