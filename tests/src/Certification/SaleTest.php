<?php
/**
 * @file
 * Sale (auth+capture) certification tests (L_S_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Test\Configuration;

class SaleTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_S_';
  private static $outfile = 'build/logs/devhubresults_L_S.txt';

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
   * Tests Visa card Sale with AVS and CVV.
   */
  public function test_L_S_1() {
    $request = new Request($this->config);
    $body = $this->data('Sale1');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('11111 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals(01, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('M', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests MasterCard Sale with AVS and CVV.
   */
  public function test_L_S_2() {
    $request = new Request($this->config);
    $body = $this->data('Sale2');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('22222 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals(10, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('M', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests Discover card Sale with AVS and CVV.
   */
  public function test_L_S_3() {
    $request = new Request($this->config);
    $body = $this->data('Sale3');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('33333 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals(10, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('M', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests American Express card Sale with AVS and CVV.
   */
  public function test_L_S_4() {
    $request = new Request($this->config);
    $body = $this->data('Sale4');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('44444 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals(13, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    // AMEX doesn't return cardValidationResult ("M") like other cards.
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests Visa card Sale with CVV without AVS.
   */
  public function test_L_S_5() {
    $request = new Request($this->config);
    $body = $this->data('Sale5');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('55555 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals(32, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests Visa card Sale with CVV and AVS (Insufficient Funds).
   */
  public function test_L_S_6() {
    $request = new Request($this->config);
    $body = $this->data('Sale6');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(110, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(34, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('P', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Insufficient Funds', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '6,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests MasterCard Sale with CVV and AVS (Invalid Account Number).
   */
  public function test_L_S_7() {
    $request = new Request($this->config);
    $body = $this->data('Sale7');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(301, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(34, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('N', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Invalid Account Number', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '7,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests Discover card Sale with CVV and AVS (Call Discover).
   */
  public function test_L_S_8() {
    $request = new Request($this->config);
    $body = $this->data('Sale8');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(123, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(34, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('P', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Call Discover', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '8,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Tests American Express card Sale with CVV and AVS (Pick Up Card).
   */
  public function test_L_S_9() {
    $request = new Request($this->config);
    $body = $this->data('Sale9');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(303, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(34, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('P', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Pick Up Card', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '9,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * @return array
   */
  private function data($key = NULL) {
    $set = [
      // Visa with AVS and CVV
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
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457010000000009',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          // ApplicationID should be unique per transaction.
          'ApplicationID' => 's12341'
        ]
      ],
      // MasterCard with AVS and CVV
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
      ],
      // Discover card with AVS and CVV
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
          'BillingName' => 'Eileen Jones',
          'BillingAddress1' => '3 Main St.',
          'BillingCity' => 'Bloomfield',
          'BillingState' => 'CT',
          'BillingZipcode' => '06002',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'DI',
          'CardNumber' => '6011010000000003',
          'ExpirationMonth' => '03',
          'ExpirationYear' => '16',
          'CVV' => '758'
        ],
        'Application' => [
          'ApplicationID' => 's12343'
        ]
      ],
      // American Express card with AVS and CVV
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
          'BillingName' => 'Bob Black',
          'BillingAddress1' => '4 Main St.',
          'BillingCity' => 'Laurel',
          'BillingState' => 'MD',
          'BillingZipcode' => '20708',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'AX',
          'CardNumber' => '375001000000005',
          'ExpirationMonth' => '04',
          'ExpirationYear' => '16'
        ],
        'Application' => [
          'ApplicationID' => 's12344'
        ]
      ],
      // Visa with CVV without AVS
      'Sale5' => [
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
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4100200300011001',
          'ExpirationMonth' => '05',
          'ExpirationYear' => '16',
          'CVV' => '463'
        ],
        'Application' => [
          'ApplicationID' => 's12345'
        ]
      ],
      // Visa with CVV and AVS (Insufficient Funds)
      'Sale6' => [
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
          'BillingName' => 'Joe Green',
          'BillingAddress1' => '6 Main St.',
          'BillingCity' => 'Derry',
          'BillingState' => 'NH',
          'BillingZipcode' => '03038',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4457010100000008',
          'ExpirationMonth' => '06',
          'ExpirationYear' => '16',
          'CVV' => '992'
        ],
        'Application' => [
          'ApplicationID' => 's12346'
        ]
      ],
      // MasterCard with CVV and AVS (Invalid Account Number)
      'Sale7' => [
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
          'BillingName' => 'Jane Murray',
          'BillingAddress1' => '7 Main St.',
          'BillingCity' => 'Amesbury',
          'BillingState' => 'MA',
          'BillingZipcode' => '01913',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112010100000002',
          'ExpirationMonth' => '07',
          'ExpirationYear' => '16',
          'CVV' => '251'
        ],
        'Application' => [
          'ApplicationID' => 's12347'
        ]
      ],
      // Discover card with CVV and AVS (Call Discover)
      'Sale8' => [
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
          'BillingName' => 'Mark Johnson',
          'BillingAddress1' => '8 Main St.',
          'BillingCity' => 'Manchester',
          'BillingState' => 'NH',
          'BillingZipcode' => '03101',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'DI',
          'CardNumber' => '6011010100000002',
          'ExpirationMonth' => '08',
          'ExpirationYear' => '16',
          'CVV' => '184'
        ],
        'Application' => [
          'ApplicationID' => 's12348'
        ]
      ],
      // American Express card with CVV and AVS (Pick Up Card)
      'Sale9' => [
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
          'BillingName' => 'James Miller',
          'BillingAddress1' => '9 Main St.',
          'BillingCity' => 'Boston',
          'BillingState' => 'MA',
          'BillingZipcode' => '02134',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'AX',
          'CardNumber' => '375001010000003',
          'ExpirationMonth' => '09',
          'ExpirationYear' => '16',
          'CVV' => '0421'
        ],
        'Application' => [
          'ApplicationID' => 's12349'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
