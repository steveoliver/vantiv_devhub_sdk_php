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
      'Address' => [
        'BillingName' => 'Mike J. Hammer',
        'BillingAddress1' => '2 Main St.',
        'BillingAddress2' => 'Apt. 222',
        'BillingCity' => 'Riverside',
        'BillingState' => 'RI',
        'BillingZipcode' => '02915',
        'BillingCountry' => 'US'
      ],
      'Card' => [
        'Type' => 'MC',
        'CardNumber' => '5112010000000003',
        'ExpirationMonth' => '02',
        'ExpirationYear' => '16',
        'CVV' => '261'
      ],
      'Application' => [
        'ApplicationID' => 's12342'
      ]
    ]);
    $this->assertEquals($result['response'], FALSE);
    $this->assertEquals($result['http_code'], 0);
  }

  public function testSendPost() {
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
      'Address' => [
        'BillingName' => 'Mike J. Hammer',
        'BillingAddress1' => '2 Main St.',
        'BillingAddress2' => 'Apt. 222',
        'BillingCity' => 'Riverside',
        'BillingState' => 'RI',
        'BillingZipcode' => '02915',
        'BillingCountry' => 'US'
      ],
      'Card' => [
        'Type' => 'MC',
        'CardNumber' => '5112010000000003',
        'ExpirationMonth' => '02',
        'ExpirationYear' => '16',
        'CVV' => '261'
      ],
      'Application' => [
        'ApplicationID' => 's12342'
      ]
    ]);
    $this->assertEquals($result['response'], FALSE);
    $this->assertEquals($result['http_code'], 0);
  }

}
