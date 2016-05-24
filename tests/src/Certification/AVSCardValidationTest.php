<?php
/**
 * @file
 * AVS and Card Validation certification tests (L_AVSCV_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Test\Configuration;

class AVSCardValidationTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_AVSCV_';
  private static $outfile = 'build/logs/devhubresults_L_AVSCV.txt';

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
  }

  public static function setUpBeforeClass() {
    file_put_contents(
      self::$outfile,
      'Test results for ' . self::$prefix . '* test suite.' . PHP_EOL . str_repeat('=', 44) . PHP_EOL
    );
  }

  /**
   * Tests successful Visa card authorization
   * (U: Issuer not certified for CVV2 processing and AVS Result 00: 5-Digit zip and address match)
   */
  public function test_L_AVSCV_1() {
    $request = new Request($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('U', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(00, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (M: Match and AVS Result 01: 9-Digit zip and address match)
   */
  public function test_L_AVSCV_2() {
    $request = new Request($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(01, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (M: Match and AVS Result 02: Postal code and address match)
   */
  public function test_L_AVSCV_3() {
    $request = new Request($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(02, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (S: CVV2/CVC2/CID should be on the card, but the merchant has indicated
   * CVV2/CVC2/CID is not present and AVS Result 10: Postal code and address match)
   */
  public function test_L_AVSCV_4() {
    $request = new Request($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('S', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful Visa card authorization
   * (M: Match and AVS Result 11: 9-Digit zip matches, address does not match)
   */
  public function test_L_AVSCV_5() {
    $request = new Request($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(11, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '5,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (M: Match and AVS Result 12: Zip does not match, address matches)
   */
  public function test_L_AVSCV_6() {
    $request = new Request($this->config);
    $body = $this->data('Authorization6');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(12, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '6,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (M: Match and AVS Result 13: Postal code does not match, address matches)
   */
  public function test_L_AVSCV_7() {
    $request = new Request($this->config);
    $body = $this->data('Authorization7');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(13, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '7,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests failed MasterCard authorization
   * (N: No Match and AVS Result 14: Postal code matches, address not verified)
   */
  public function test_L_AVSCV_8() {
    $request = new Request($this->config);
    $body = $this->data('Authorization8');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(358, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('N', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(14, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Restricted by Litle due to security code mismatch', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '8,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests failed MasterCard authorization
   * (N: No Match and AVS Result 20: Neither zip nor address match)
   */
  public function test_L_AVSCV_9() {
    $request = new Request($this->config);
    $body = $this->data('Authorization9');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(358, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('N', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(20, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Restricted by Litle due to security code mismatch', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '9,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (P: Not Processed and AVS Result 30: AVS service not supported by issuer)
   */
  public function test_L_AVSCV_10() {
    $request = new Request($this->config);
    $body = $this->data('Authorization10');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('P', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(30, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '10,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (U: Issuer is not certified for CVV2/CVC2/CID processing and 31: AVS system not available)
   */
  public function test_L_AVSCV_11() {
    $request = new Request($this->config);
    $body = $this->data('Authorization11');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('U', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(31, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '11,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (S: CVV2/CVC2/CID should be on the card, but the merchant has indicated
   * CVV2/CVC2/CID is not present and 32: Address unavailable)
   */
  public function test_L_AVSCV_12() {
    $request = new Request($this->config);
    $body = $this->data('Authorization12');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('S', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(32, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '12,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests successful MasterCard authorization
   * (P: Not Processed and 34: AVS not performed)
   */
  public function test_L_AVSCV_13() {
    $request = new Request($this->config);
    $body = $this->data('Authorization13');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('P', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(34, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals('654321', $response->litleOnlineResponse->authorizationResponse->authCode);
    file_put_contents(self::$outfile, self::$prefix . '13,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Tests failed American Express card authorization
   * (N: No Match and 01: 9-Digit zip and address match)
   */
  public function test_L_AVSCV_14() {
    $request = new Request($this->config);
    $body = $this->data('Authorization14');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(352, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('N', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Decline CVV2/CID Fail', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals(20, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    file_put_contents(self::$outfile, self::$prefix . '14,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
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
