<?php
/**
 * @file
 * Void certification tests (L_V_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Test\Config;

class VoidTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_V_';
  private static $outfile = 'build/logs/devhubresults_L_V.txt';

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
  public function test_L_V_1() {
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
   * @depends test_L_V_1
   */
  public function test_L_V_1A($TransactionID) {
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
   * @depends test_L_V_1A
   */
  public function test_L_V_1B($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Credit1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'credit', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1B,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->creditResponse->TransactionID;
  }

  /**
   * Void the credit transaction above.
   *
   * @depends test_L_V_1B
   */
  public function test_L_V_1C($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Void1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body, 'payment', 'credit', 'void', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->voidResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->voidResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '1C,' . $response->RequestID . PHP_EOL, FILE_APPEND);
  }

  /**
   * Tests sale of MasterCard with CVV and AVS.
   */
  public function test_L_V_2() {
    $request = new Request($this->config);
    $body = $this->data('Sale2');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals('22222 ', $response->litleOnlineResponse->saleResponse->authCode);
    $this->assertEquals('M', $response->litleOnlineResponse->saleResponse->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Voids the sale transaction above.
   *
   * @depends test_L_V_2
   */
  public function test_L_V_2A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Void2');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'void', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->voidResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->voidResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '2A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->voidResponse->TransactionID;
  }

  /**
   * Tests return transaction on Visa card with CVV and no AVS.
   */
  public function test_L_V_3() {
    $request = new Request($this->config);
    $body = $this->data('Return3');
    $result = $request->send($body, 'payment', 'credit', 'return', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->creditResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->creditResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->creditResponse->TransactionID;
  }

  /**
   * Voids the return transaction above.
   *
   * @depends test_L_V_3
   */
  public function test_L_V_3A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Void3');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'void', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->voidResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->voidResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '3A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->voidResponse->TransactionID;
  }

  /**
   * Tests Visa card sale with AVS and CVV (Insufficient Funds).
   */
  public function test_L_V_4() {
    $request = new Request($this->config);
    $body = $this->data('Sale4');
    $result = $request->send($body, 'payment', 'credit', 'sale', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(110, $response->litleOnlineResponse->saleResponse->response);
    $this->assertEquals(34, $response->litleOnlineResponse->saleResponse->fraudResult->avsResult);
    $this->assertEquals('Insufficient Funds', $response->litleOnlineResponse->saleResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->saleResponse->TransactionID;
  }

  /**
   * Voids the sale transaction above.
   *
   * @depends test_L_V_4
   */
  public function test_L_V_4A($TransactionID) {
    $request = new Request($this->config);
    $body = $this->data('Void4');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body, 'payment', 'credit', 'void', 'POST');
    $response = json_decode($result['response']);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->litleOnlineResponse->voidResponse->response);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->voidResponse->message);
    file_put_contents(self::$outfile, self::$prefix . '4A,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    return $response->litleOnlineResponse->voidResponse->TransactionID;
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
      'Void1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12341v'
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
          'ApplicationID' => 'a12342s'
        ]
      ],
      'Void2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'a12342v'
        ]
      ],
      'Return3' => [
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
          'ApplicationID' => 'r12343'
        ]
      ],
      'Void3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 'r12343v'
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
          'ApplicationID' => 's12344'
        ]
      ],
      'Void4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Application' => [
          'ApplicationID' => 's12344v'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
