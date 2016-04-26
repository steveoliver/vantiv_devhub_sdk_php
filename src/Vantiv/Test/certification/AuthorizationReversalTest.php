<?php
/**
 * @file
 * Authorization reversal certification tests (L_AR_*).
 */

namespace Vantiv\Test\certification;

use Vantiv\Request;
use Vantiv\Test\Config;

class AuthorizationReversalTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_AR_';
  private static $outfile = 'devhubresults_L_AR.txt';

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

  public function test_L_AR_1() {
    $request = new Request($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AR_1
   */
  public function test_L_AR_1A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * @depends test_L_AR_1
   */
  public function test_L_AR_1B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationReversal1');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'reversal', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->authReversalResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->authReversalResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AR_2() {
    $request = new Request($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AR_2
   */
  public function test_L_AR_2A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationReversal2');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'reversal', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->authReversalResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->authReversalResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AR_3() {
    $request = new Request($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AR_3
   */
  public function test_L_AR_3A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationReversal3');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'reversal', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authReversalResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authReversalResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AR_4() {
    $request = new Request($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AR_4
   */
  public function test_L_AR_4A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion4');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * @depends test_L_AR_4
   */
  public function test_L_AR_4B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationReversal4');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'reversal', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->authReversalResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->authReversalResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  public function test_L_AR_5() {
    $request = new Request($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * @depends test_L_AR_5
   */
  public function test_L_AR_5A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationReversal5');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'reversal', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->authReversalResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->authReversalResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * @return array
   */
  private function data($key = NULL) {
    $set = [
      // Authorizes 100.10
      'Authorization1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '100.10',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Address' => [
          'BillingName' => 'John Smith',
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
      // Captures 50.50 of 100.10
      'AuthorizationCompletion1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'TransactionAmount' => '50.50',
        ],
        'Application' => [
          'ApplicationID' => 'a12341c'
        ]
      ],
      // Reverses the authorization of 100.10
      'AuthorizationReversal1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12341r'
        ]
      ],
      // Authorizes 200.20
      'Authorization2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '200.20',
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
      // Reverses the authorization of 200.20.
      'AuthorizationReversal2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12342r'
        ]
      ],
      // Authorizes 300.30
      'Authorization3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '300.30',
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
      // Reverses the authorization of 300.30.
      'AuthorizationReversal3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12343r'
        ]
      ],
      // Authorizes 101.00 with no CVV.
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
      // Captures 50.50 of 101.00 authorization.
      'AuthorizationCompletion4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'TransactionAmount' => '50.50'
        ],
        'Application' => [
          'ApplicationID' => 'a12344c'
        ]
      ],
      // Reverses remaining 50.50 of 101.00 authorization.
      'AuthorizationReversal4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'TransactionAmount' => '50.50'
        ],
        'Application' => [
          'ApplicationID' => 'a12344r'
        ]
      ],
      // Authorizes 205.00 with no CVV.
      'Authorization5' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '205.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'AX',
          'CardNumber' => '375000026600004',
          'ExpirationMonth' => '05',
          'ExpirationYear' => '16'
        ],
        'Application' => [
          'ApplicationID' => 'a12345'
        ]
      ],
      // Reverses 100.00 of the 205.00 authorization.
      // Supposedly (according to LitleXML docs), AMEX doesn't support partial
      // authorization reversals.  I don't know why this seems to work.
      'AuthorizationReversal5' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'TransactionAmount' => '100.00'
        ],
        'Application' => [
          'ApplicationID' => 'a12345r'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
