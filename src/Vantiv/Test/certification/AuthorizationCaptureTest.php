<?php
/**
 * @file
 * Authorization and capture certification tests (L_AC_*).
 */

namespace Vantiv\Test\certification;

use Vantiv\Request;
use Vantiv\Test\Config;

class AuthorizationCaptureTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_AC_';
  private static $outfile = 'devhubresults_L_AC.txt';

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

  public function test_L_AC_1() {
    $request = new Request($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AC_1
   */
  public function test_L_AC_1A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion1');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_2() {
    $request = new Request($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AC_2
   */
  public function test_L_AC_2A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion2');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_3() {
    $request = new Request($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AC_3
   */
  public function test_L_AC_3A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion3');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_4() {
    $request = new Request($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AC_4
   */
  public function test_L_AC_4A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion4');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_5() {
    $request = new Request($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    file_put_contents(self::$outfile, self::$prefix . '5,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AC_5
   */
  public function test_L_AC_5A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion5');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_6() {
    $request = new Request($this->config);
    $body = $this->data('InsufficientFunds');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(110, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Insufficient Funds', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '6,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_7() {
    $request = new Request($this->config);
    $body = $this->data('InvalidAccountNumber');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(301, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Invalid Account Number', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '7,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_8() {
    $request = new Request($this->config);
    $body = $this->data('CallDiscover');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(123, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Call Discover', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '8,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AC_9() {
    $request = new Request($this->config);
    $body = $this->data('PickUpCard');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(303, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Pick Up Card', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '9,' . $response->RequestID . PHP_EOL, FILE_APPEND);
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
          'CardNumber' => '4457010000000009',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12341'
        ]
      ],
      'AuthorizationCompletion1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12341c'
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
          'ApplicationID' => 'a12342'
        ]
      ],
      'AuthorizationCompletion2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12342c'
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
          'ApplicationID' => 'a12343'
        ]
      ],
      'AuthorizationCompletion3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12343c'
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
          'ApplicationID' => 'a12344'
        ]
      ],
      'AuthorizationCompletion4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12344c'
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
        'Card' => [
          'Type' => 'VI',
          'CardNumber' => '4100200300011001',
          'ExpirationMonth' => '05',
          'ExpirationYear' => '16',
          'CVV' => '463'
        ],
        'Application' => [
          'ApplicationID' => 'a12345'
        ]
      ],
      'AuthorizationCompletion5' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12345c'
        ]
      ],
      'InsufficientFunds' => [
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
          'ApplicationID' => '12346'
        ]
      ],
      'InvalidAccountNumber' => [
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
          'ApplicationID' => '12347'
        ]
      ],
      'CallDiscover' => [
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
          'ApplicationID' => '12348'
        ]
      ],
      'PickUpCard' => [
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
          'ApplicationID' => '1234'
        ]
      ]
    ];

    return $key ? $set[$key] : $set;
  }
}
