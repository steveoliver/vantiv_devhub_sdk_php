<?php
/**
 * @file
 * Address Responses certification tests (L_ADR_*).
 */

namespace Vantiv\Test\certification;

use Vantiv\Request;
use Vantiv\Test\Config;

class AVSResponseTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_ADR_';
  private static $outfile = 'devhubresults_L_ADR.txt';

  public function __construct() {
    $config = new Config();
    $this->config = $config->config;
  }

  public static function setUpBeforeClass() {
    file_put_contents(
      self::$outfile,
      'Test results for ' . self::$prefix . '* test suite.' . PHP_EOL . str_repeat('=', 44) . PHP_EOL
    );
  }

  public function test_L_ADR_1() {
    $request = new Request($this->config);
    $body = $this->data('Sale1');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    print(var_dump($result['response']));
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(00, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  public function test_L_ADR_2() {
    $request = new Request($this->config);
    $body = $this->data('Sale2');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    print(var_dump($result['response']));
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(01, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  public function test_L_ADR_3() {
    $request = new Request($this->config);
    $body = $this->data('Sale3');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    print(var_dump($result['response']));
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(10, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  public function test_L_ADR_4() {
    $request = new Request($this->config);
    $body = $this->data('Sale4');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    print(var_dump($result['response']));
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(20, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
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
