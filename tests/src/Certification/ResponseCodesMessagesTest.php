<?php
/**
 * @file
 * Response Reason Codes and Messages certification tests (L_RRC_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request\Credit\Authorization;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

/**
 * Class ResponseCodesMessagesTest
 * @package Vantiv\Test\Certification
 * @group Certification
 */
class ResponseCodesMessagesTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_RRC_';
    $outfile = 'build/logs/devhubresults_L_RRC.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  public function test_L_RRC_1() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization1');
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

  public function test_L_RRC_2() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('2', $requestID);
    return $response->TransactionID;
  }

  public function test_L_RRC_3() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  public function test_L_RRC_4() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  public function test_L_RRC_5() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(120, $response->response);
    $this->assertEquals(02, $response->fraudResult->avsResult);
    $this->assertEquals('Call Issuer', $response->message);
    $this->logger->log('5', $requestID);
    return $response->TransactionID;
  }

  public function test_L_RRC_6() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization6');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(123, $response->response);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Call Discover', $response->message);
    $this->logger->log('6', $requestID);
    return $response->TransactionID;
  }

  public function test_L_RRC_7() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization7');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(120, $response->response);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Call Issuer', $response->message);
    $this->logger->log('7', $requestID);
    return $response->TransactionID;
  }

  /**
   * @return array
   */
  private function data($key = NULL) {
    $set = [
      'Authorization1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#4457000800000002',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457000800000002',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
//          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12341'
        ]
      ],
      'Authorization2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#4457000900000001',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457000900000001',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12342'
        ]
      ],
      'Authorization3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#4457001000000008',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457001000000008',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12343'
        ]
      ],
      'Authorization4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#5112000900000005',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112000900000005',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12344'
        ]
      ],
      'Authorization5' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#375000030000001',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'AX',
          'CardNumber' => '375000030000001',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12345'
        ]
      ],
      'Authorization6' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#6011000400000000',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'DI',
          'CardNumber' => '6011000400000000',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12346'
        ]
      ],
      'Authorization7' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => 'RRC-card#4457001200000006',
          'TransactionAmount' => '101.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457001200000006',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12347'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
