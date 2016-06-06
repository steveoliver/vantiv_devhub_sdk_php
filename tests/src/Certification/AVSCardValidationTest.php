<?php
/**
 * @file
 * AVS and Card Validation certification tests (L_AVSCV_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request\Credit\Authorization;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

/**
 * Class AVSCardValidationTest
 * @package Vantiv\Test\Certification
 * @group Certification
 */
class AVSCardValidationTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_AVSCV_';
    $outfile = 'build/logs/devhubresults_L_AVSCV.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  /**
   * Tests successful Visa card authorization
   * (U: Issuer not certified for CVV2 processing and AVS Result 00: 5-Digit zip and address match)
   */
  public function test_L_AVSCV_1() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('U', $response->fraudResult->cardValidationResult);
    $this->assertEquals(00, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('1', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (M: Match and AVS Result 01: 9-Digit zip and address match)
   */
  public function test_L_AVSCV_2() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(01, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('2', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (M: Match and AVS Result 02: Postal code and address match)
   */
  public function test_L_AVSCV_3() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(02, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (S: CVV2/CVC2/CID should be on the card, but the merchant has indicated
   * CVV2/CVC2/CID is not present and AVS Result 10: Postal code and address match)
   */
  public function test_L_AVSCV_4() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('S', $response->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (M: Match and AVS Result 11: 9-Digit zip matches, address does not match)
   */
  public function test_L_AVSCV_5() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(11, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('5', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (M: Match and AVS Result 12: Zip does not match, address matches)
   */
  public function test_L_AVSCV_6() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization6');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(12, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('6', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (M: Match and AVS Result 13: Postal code does not match, address matches)
   */
  public function test_L_AVSCV_7() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization7');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(13, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('7', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests failed MasterCard authorization
   * (N: No Match and AVS Result 14: Postal code matches, address not verified)
   */
  public function test_L_AVSCV_8() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization8');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(358, $response->response);
    $this->assertEquals('N', $response->fraudResult->cardValidationResult);
    $this->assertEquals(14, $response->fraudResult->avsResult);
    $this->assertEquals('Restricted by Litle due to security code mismatch', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('8', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests failed MasterCard authorization
   * (N: No Match and AVS Result 20: Neither zip nor address match)
   */
  public function test_L_AVSCV_9() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization9');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(358, $response->response);
    $this->assertEquals('N', $response->fraudResult->cardValidationResult);
    $this->assertEquals(20, $response->fraudResult->avsResult);
    $this->assertEquals('Restricted by Litle due to security code mismatch', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('9', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (P: Not Processed and AVS Result 30: AVS service not supported by issuer)
   */
  public function test_L_AVSCV_10() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization10');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('P', $response->fraudResult->cardValidationResult);
    $this->assertEquals(30, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('10', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (U: Issuer is not certified for CVV2/CVC2/CID processing and 31: AVS system not available)
   */
  public function test_L_AVSCV_11() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization11');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('U', $response->fraudResult->cardValidationResult);
    $this->assertEquals(31, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('11', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (S: CVV2/CVC2/CID should be on the card, but the merchant has indicated
   * CVV2/CVC2/CID is not present and 32: Address unavailable)
   */
  public function test_L_AVSCV_12() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization12');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('S', $response->fraudResult->cardValidationResult);
    $this->assertEquals(32, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('12', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (P: Not Processed and 34: AVS not performed)
   */
  public function test_L_AVSCV_13() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization13');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('P', $response->fraudResult->cardValidationResult);
    $this->assertEquals(34, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('654321', $response->authCode);
    $this->logger->log('13', $requestID);
    return $response->TransactionID;
  }

  /**
   * Tests failed American Express card authorization
   * (N: No Match and 01: 9-Digit zip and address match)
   */
  public function test_L_AVSCV_14() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization14');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(352, $response->response);
    $this->assertEquals('N', $response->fraudResult->cardValidationResult);
    $this->assertEquals('Decline CVV2/CID Fail', $response->message);
    $this->assertEquals(20, $response->fraudResult->avsResult);
    $this->logger->log('14', $requestID);
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '4457000300000007',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '4457000100000009',
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '4457003100000003',
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '4457000400000006',
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '4457000200000008',
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '5112000100000003',
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
          'ReferenceNumber' => '1',
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
          'CardNumber' => '5112002100000009',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12347'
        ]
      ],
      'Authorization8' => [
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112002200000008',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12348'
        ]
      ],
      'Authorization9' => [
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112000200000002',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12349'
        ]
      ],
      'Authorization10' => [
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112000300000001',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a123410'
        ]
      ],
      'Authorization11' => [
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112000400000000',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a123411'
        ]
      ],
      'Authorization12' => [
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
//        'Address' => [
//          'BillingName' => 'John & Mary Smith',
//          'BillingAddress1' => '1 Main St.',
//          'BillingCity' => 'Burlington',
//          'BillingState' => 'MA',
//          'BillingZipcode' => '01803-3747',
//          'BillingCountry' => 'US'
//        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112010400000009',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a123412'
        ]
      ],
      'Authorization13' => [
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112000600000008',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a123413'
        ]
      ],
      'Authorization14' => [
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'AX',
          'CardNumber' => '374313304211118',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a123414'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
