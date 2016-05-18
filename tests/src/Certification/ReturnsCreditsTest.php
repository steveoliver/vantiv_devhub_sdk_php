<?php
/**
 * @file
 * Returns and credits certification tests (L_RC_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Test\Config;

class ReturnsCreditsTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_RC_';
  private static $outfile = 'build/logs/devhubresults_L_RC.txt';

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

  /**
   * Tests authorization of Visa with CVV and AVS.
   */
  public function test_L_RC_1() {
    $request = new Request($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('11111 ', $response->litleOnlineResponse->authorizationResponse->authCode);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_1
   */
  public function test_L_RC_1A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion1');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->captureResponse->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_1A
   */
  public function test_L_RC_1B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests authorization of MasterCard with CVV and AVS.
   */
  public function test_L_RC_2() {
    $request = new Request($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('22222 ', $response->litleOnlineResponse->authorizationResponse->authCode);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_2
   */
  public function test_L_RC_2A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion2');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->captureResponse->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_2A
   */
  public function test_L_RC_2B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit2');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests authorization of Discover card with CVV and AVS.
   */
  public function test_L_RC_3() {
    $request = new Request($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('33333 ', $response->litleOnlineResponse->authorizationResponse->authCode);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_3
   */
  public function test_L_RC_3A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion3');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->captureResponse->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_3A
   */
  public function test_L_RC_3B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit3');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests authorization of American Express card with AVS without CVV.
   */
  public function test_L_RC_4() {
    $request = new Request($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('44444 ', $response->litleOnlineResponse->authorizationResponse->authCode);
    $this->assertEquals(13, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_4
   */
  public function test_L_RC_4A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion4');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->captureResponse->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_4A
   */
  public function test_L_RC_4B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit4');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests authorization of Visa card with CVV without AVS.
   */
  public function test_L_RC_5() {
    $request = new Request($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('55555 ', $response->litleOnlineResponse->authorizationResponse->authCode);
    $this->assertEquals(32, $response->litleOnlineResponse->authorizationResponse->fraudResult->avsResult);
    $this->assertEquals('M', $response->litleOnlineResponse->authorizationResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->authorizationResponse->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_5
   */
  public function test_L_RC_5A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('AuthorizationCompletion5');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'authorizationCompletion', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->captureResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->captureResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->captureResponse->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_5A
   */
  public function test_L_RC_5B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit5');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '5B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests Visa card sale with CVV and AVS.
   */
  public function test_L_RC_6() {
    $request = new Request($this->config);
    $body = $this->data('Sale6');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('11111 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals('M', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '6,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Credits the sale transaction above.
   *
   * @depends test_L_RC_6
   */
  public function test_L_RC_6A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit6');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '6A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests MasterCard sale with CVV and AVS.
   */
  public function test_L_RC_7() {
    $request = new Request($this->config);
    $body = $this->data('Sale7');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '7,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Credits the sale transaction above.
   *
   * @depends test_L_RC_7
   */
  public function test_L_RC_7A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit7');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
  }

  /**
   * Tests Visa card return with CVV without AVS.
   */
  public function test_L_RC_8() {
    $request = new Request($this->config);
    $body = $this->data('Return8');
    $result = $request->send($body, 'payment', 'credit', 'return', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '8,' . $response->RequestID . PHP_EOL, FILE_APPEND);
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
      'Credit1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12341cr'
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
      'Credit2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12342cr'
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
      'Credit3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12343cr'
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
      'Credit4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12344cr'
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
      'Credit5' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12345cr'
        ]
      ],
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
          'ApplicationID' => 'a12346'
        ]
      ],
      'Credit6' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12346cr'
        ]
      ],
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
          'BillingName' => 'John & Mary Smith',
          'BillingAddress1' => '1 Main St.',
          'BillingCity' => 'Burlington',
          'BillingState' => 'MA',
          'BillingZipcode' => '01803-3747',
          'BillingCountry' => 'US'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5112010000000003',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12347'
        ]
      ],
      'Credit7' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12347cr'
        ]
      ],
      'Return8' => [
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
          'CardNumber' => '4457010000000009',
          'ExpirationMonth' => '01',
          'ExpirationYear' => '16',
          'CVV' => '349'
        ],
        'Application' => [
          'ApplicationID' => 'a12348'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
