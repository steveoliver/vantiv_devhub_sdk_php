<?php
/**
 * @file
 * Address Responses certification tests (L_ADR_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request\Credit\Sale;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

class AVSResponseTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_ADR_';
    $outfile = 'build/logs/devhubresults_L_ADR.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  public function test_L_ADR_1() {
    $request = new Sale($this->config);
    $body = $this->data('Sale1');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('1', $requestID);
    return $response->TransactionID;
  }

  public function test_L_ADR_2() {
    $request = new Sale($this->config);
    $body = $this->data('Sale2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(01, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('2', $requestID);
    return $response->TransactionID;
  }

  public function test_L_ADR_3() {
    $request = new Sale($this->config);
    $body = $this->data('Sale3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(10, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  public function test_L_ADR_4() {
    $request = new Sale($this->config);
    $body = $this->data('Sale4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(20, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  /**
   * @return array
   */
  private function data($key = NULL) {
    $set = [
      'Sale1' => [
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
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '95 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '95022',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457000600000004',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
//          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12341'
        ]
      ],
      'Sale2' => [
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
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '95 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '950221111',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457000600000004',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
//          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12342'
        ]
      ],
      'Sale3' => [
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
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '100 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '95022',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457000600000004',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
//          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12343'
        ]
      ],
      'Sale4' => [
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
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '100 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '02134',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457000600000004',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
//          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12344'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
