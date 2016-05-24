<?php
/**
 * @file
 * Tokenization certification tests (L_T_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Test\Configuration;

class TokenTest extends \PHPUnit_Framework_TestCase {

  private $config = [];
  private static $prefix = 'L_T_';
  private static $outfile = 'build/logs/devhubresults_L_T.txt';

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
   * Tests successful payment account creation with Visa without CVV without AVS.
   */
  public function test_L_T_1() {
    $request = new Request($this->config);
    $body = $this->data('PaymentAccountCreate1');
    $result = $request->send($body, 'payment', 'services', 'paymentAccountCreate', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '1,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertContains($response->litleOnlineResponse->registerTokenResponse->response, [
      801,
      802
    ]);
    $this->assertContains($response->litleOnlineResponse->registerTokenResponse->bin, [
      445711,
      445701
    ]);
//    $this->assertEquals('xxxxxxxxxxxx0123', $response->litleOnlineResponse->registerTokenResponse->PaymentAccountID);
    $this->assertEquals('VI', $response->litleOnlineResponse->registerTokenResponse->Type);
    $this->assertContains($response->litleOnlineResponse->registerTokenResponse->message, [
      'Account number was successfully registered',
      'Account number was previously registered'
    ]);
  }

  /**
   * Tests failed payment account creation with Visa (Invalid credit card number).
   */
  public function test_L_T_2() {
    $request = new Request($this->config);
    $body = $this->data('PaymentAccountCreate2');
    $result = $request->send($body, 'payment', 'services', 'paymentAccountCreate', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '2,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(820, $response->litleOnlineResponse->registerTokenResponse->response);
    $this->assertEquals('Credit card number was invalid', $response->litleOnlineResponse->registerTokenResponse->message);
  }

  /**
   * Tests failed payment account creation with Visa (Account number previously registered).
   */
  public function test_L_T_3() {
    $request = new Request($this->config);
    $body = $this->data('PaymentAccountCreate3');
    $result = $request->send($body, 'payment', 'services', 'paymentAccountCreate', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '3,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(802, $response->litleOnlineResponse->registerTokenResponse->response);
    $this->assertEquals(445711, $response->litleOnlineResponse->registerTokenResponse->bin);
    $this->assertEquals('Account number was previously registered', $response->litleOnlineResponse->registerTokenResponse->message);
  }

  /**
   * Tests successful payment account creation with Checking account.
   */
  public function test_L_T_4() {
    $request = new Request($this->config);
    $body = $this->data('PaymentAccountCreate4');
    $result = $request->send($body, 'payment', 'services', 'paymentAccountCreate', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '4,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(801, $response->litleOnlineResponse->registerTokenResponse->response);
    $this->assertEquals(998, $response->litleOnlineResponse->registerTokenResponse->eCheckAccountSuffix);
    $this->assertEquals('Account number was successfully registered', $response->litleOnlineResponse->registerTokenResponse->message);
    $this->assertEquals('EC', $response->litleOnlineResponse->registerTokenResponse->Type);
  }

  /**
   * Tests failed payment account creation with Checking account (Invalid routing number).
   */
  public function test_L_T_5() {
    $request = new Request($this->config);
    $body = $this->data('PaymentAccountCreate5');
    $result = $request->send($body, 'payment', 'services', 'paymentAccountCreate', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '5,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(900, $response->litleOnlineResponse->registerTokenResponse->response);
    $this->assertEquals('Invalid Bank Routing Number', $response->litleOnlineResponse->registerTokenResponse->message);
  }

  /**
   * Tests successful payment account creation with MasterCard authorization.
   */
  public function test_L_T_6() {
    $request = new Request($this->config);
    $body = $this->data('Authorization6');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '6,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals(801, $response->litleOnlineResponse->authorizationResponse->tokenResponseCode);
    $this->assertEquals(543510, $response->litleOnlineResponse->authorizationResponse->tokenResponse->bin);
    $this->assertEquals(1112000188100196, $response->litleOnlineResponse->authorizationResponse->tokenResponse->PaymentAccountID);
    $this->assertEquals('Account number was successfully registered', $response->litleOnlineResponse->authorizationResponse->tokenResponse->tokenMessage);
  }

  /**
   * Tests failed payment account creation with MasterCard authorization (Invalid account number).
   */
  public function test_L_T_7() {
    $request = new Request($this->config);
    $body = $this->data('Authorization7');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '7,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Invalid Account Number', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals(301, $response->litleOnlineResponse->authorizationResponse->response);
  }

  /**
   * Tests failed payment account creation but successful MasterCard authorization (Account previously registered).
   */
  public function test_L_T_8() {
    $request = new Request($this->config);
    $body = $this->data('Authorization8');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '8,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals(802, $response->litleOnlineResponse->authorizationResponse->tokenResponseCode);
    $this->assertEquals('MC', $response->litleOnlineResponse->authorizationResponse->tokenResponse->Type);
    $this->assertEquals(543510, $response->litleOnlineResponse->authorizationResponse->tokenResponse->bin);
    $this->assertEquals(1112000188100196, $response->litleOnlineResponse->authorizationResponse->tokenResponse->PaymentAccountID);
    $this->assertEquals('Account number was previously registered', $response->litleOnlineResponse->authorizationResponse->tokenResponse->tokenMessage);
    return $response->litleOnlineResponse->authorizationResponse->tokenResponse->PaymentAccountID;
  }

  /**
   * Tests successful authorization with PaymentAccountID from test_L_T_8.
   *
   * @depends test_L_T_8
   */
  public function test_L_T_9($paymentAccountID) {
    $request = new Request($this->config);
    $body = $this->data('Authorization9');
    // Add PaymentAccount from previous authorization / account creation.
    // PaymentAccountID used instead of Card.CardNumber.
    $body['PaymentAccount'] = ['PaymentAccountID' => $paymentAccountID];
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '9,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->litleOnlineResponse->authorizationResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->authorizationResponse->response);
  }

  /**
   * Tests failed authorization using wrong PaymentAccountID (Token not found).
   */
  public function test_L_T_10() {
    $request = new Request($this->config);
    $body = $this->data('Authorization10');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '10,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(822, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Token was not found', $response->litleOnlineResponse->authorizationResponse->message);
  }

  /**
   * Tests failed authorization using wrong PaymentAccountID (Token not found).
   */
  public function test_L_T_11() {
    $request = new Request($this->config);
    $body = $this->data('Authorization11');
    $result = $request->send($body, 'payment', 'credit', 'authorization', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '11,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(823, $response->litleOnlineResponse->authorizationResponse->response);
    $this->assertEquals('Token was invalid', $response->litleOnlineResponse->authorizationResponse->message);
  }

  /**
   * Tests successful payment account creation with eCheck sale transaction.
   */
  public function test_L_T_12() {
    $request = new Request($this->config);
    $body = $this->data('Sale12');
    $result = $request->send($body, 'payment', 'check', 'sale', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '12,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->litleOnlineResponse->echeckSalesResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->echeckSalesResponse->response);
    $this->assertEquals(801, $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->tokenResponseCode);
    $this->assertEquals(003, $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->tokenMessage);
  }

  /**
   * Tests successful payment account creation with eCheck sale transaction.
   */
  public function test_L_T_13() {
    $request = new Request($this->config);
    $body = $this->data('Sale13');
    $result = $request->send($body, 'payment', 'check', 'sale', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '13,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->litleOnlineResponse->echeckSalesResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->echeckSalesResponse->response);
    $this->assertEquals(801, $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->tokenResponseCode);
    $this->assertEquals(999, $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->tokenMessage);
  }

  /**
   * Tests successful payment account creation with eCheck return transaction.
   */
  public function test_L_T_14() {
    $request = new Request($this->config);
    $body = $this->data('Return14');
    $result = $request->send($body, 'payment', 'check', 'return', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '14,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Transaction Received', $response->litleOnlineResponse->echeckCreditResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->echeckCreditResponse->response);
    $this->assertEquals(801, $response->litleOnlineResponse->echeckCreditResponse->tokenResponse->tokenResponseCode);
    $this->assertEquals(999, $response->litleOnlineResponse->echeckCreditResponse->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->litleOnlineResponse->echeckCreditResponse->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->litleOnlineResponse->echeckCreditResponse->tokenResponse->tokenMessage);
  }

  /**
   * Tests successful payment account creation with eCheck sale transaction.
   */
  public function test_L_T_15() {
    $request = new Request($this->config);
    $body = $this->data('Sale15');
    $result = $request->send($body, 'payment', 'check', 'sale', 'POST');
    $response = json_decode($result['response']);
    file_put_contents(self::$outfile, self::$prefix . '15,' . $response->RequestID . PHP_EOL, FILE_APPEND);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->litleOnlineResponse->echeckSalesResponse->message);
    $this->assertEquals(000, $response->litleOnlineResponse->echeckSalesResponse->response);
    $this->assertEquals(801, $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->tokenResponseCode);
    $this->assertEquals(993, $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->litleOnlineResponse->echeckSalesResponse->tokenResponse->tokenMessage);
  }

  /**
   * @return array
   */
  private function data($key = NULL) {
    $set = [
      'PaymentAccountCreate1' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          // AccountNumber instead of CardNumber here when submitting a paymentAccountCreate request.
          'AccountNumber' => '4457119922390123',
        ],
        'Application' => [
          'ApplicationID' => 'pac12341'
        ]
      ],
      'PaymentAccountCreate2' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'AccountNumber' => '4457119999999999',
        ],
        'Application' => [
          'ApplicationID' => 'pac12342'
        ]
      ],
      'PaymentAccountCreate3' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'AccountNumber' => '4457119922390123',
        ],
        'Application' => [
          'ApplicationID' => 'pac12343'
        ]
      ],
      'PaymentAccountCreate4' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'DemandDepositAccount' => [
          'AccountNumber' => '1099999998',
          'RoutingNumber' => '011100012'
        ],
        'Application' => [
          'ApplicationID' => 'pac12344'
        ]
      ],
      'PaymentAccountCreate5' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'DemandDepositAccount' => [
          'AccountNumber' => '1022222102',
          'RoutingNumber' => '1145_7895'
        ],
        'Application' => [
          'ApplicationID' => 'pac12345'
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
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5435101234510196',
          'ExpirationMonth' => '11',
          'ExpirationYear' => '16',
          'CVV' => '987'
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
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5435109999999999',
          'ExpirationMonth' => '11',
          'ExpirationYear' => '16',
          'CVV' => '987'
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
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'MC',
          'CardNumber' => '5435101234510196',
          'ExpirationMonth' => '11',
          'ExpirationYear' => '16',
          'CVV' => '987'
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
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'MC',
          'ExpirationMonth' => '11',
          'ExpirationYear' => '16',
          'CVV' => '987'
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
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'MC',
          'ExpirationMonth' => '11',
          'ExpirationYear' => '16',
          'CVV' => '987'
        ],
        'PaymentAccount' => [
          'PaymentAccountID' => '1111000100092332'
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
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'Card' => [
          'Type' => 'MC',
          'ExpirationMonth' => '11',
          'ExpirationYear' => '16',
          'CVV' => '987'
        ],
        'PaymentAccount' => [
          'PaymentAccountID' => '1112000100000085'
        ],
        'Application' => [
          'ApplicationID' => 'a123411'
        ]
      ],
      'Sale12' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'DemandDepositAccount' => [
          'DDAAccountType' => 'Checking',
          'AccountNumber' => '1099999003',
          'RoutingNumber' => '011100012',
        ],
        'Address' => [
          'BillingName' => 'James Miller',
          'BillingAddress1' => '9 Main St.',
          'BillingCity' => 'Boston',
          'BillingState' => 'MA',
          'BillingZipcode' => '02134',
          'BillingCountry' => 'US'
        ],
        'Application' => [
          'ApplicationID' => 'a123412'
        ]
      ],
      'Sale13' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'DemandDepositAccount' => [
          'DDAAccountType' => 'Checking',
          'AccountNumber' => '1099999999',
          'RoutingNumber' => '011100012',
        ],
        'Address' => [
          'BillingName' => 'James Miller',
          'BillingAddress1' => '9 Main St.',
          'BillingCity' => 'Boston',
          'BillingState' => 'MA',
          'BillingZipcode' => '02134',
          'BillingCountry' => 'US'
        ],
        'Application' => [
          'ApplicationID' => 'a123412'
        ]
      ],
      'Return14' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'DemandDepositAccount' => [
          'DDAAccountType' => 'Checking',
          'AccountNumber' => '1099999999',
          'RoutingNumber' => '011100012',
        ],
        'Address' => [
          'BillingName' => 'James Miller',
          'BillingAddress1' => '9 Main St.',
          'BillingCity' => 'Boston',
          'BillingState' => 'MA',
          'BillingZipcode' => '02134',
          'BillingCountry' => 'US'
        ],
        'Application' => [
          'ApplicationID' => 'a123413'
        ]
      ],
      'Sale15' => [
        'Credentials' => [
          'AcceptorID' => '1147003'
        ],
        'Reports' => [
          'ReportGroup' => '1243'
        ],
        'Transaction' => [
          'ReferenceNumber' => '1',
          'TransactionAmount' => '150.00',
          'OrderSource' => 'ecommerce',
          'CustomerID' => '1'
        ],
        'DemandDepositAccount' => [
          'DDAAccountType' => 'Corporate',
          'AccountNumber' => '6099999993',
          'RoutingNumber' => '211370545',
        ],
        'Address' => [
          'BillingName' => 'James Miller',
          'BillingAddress1' => '9 Main St.',
          'BillingCity' => 'Boston',
          'BillingState' => 'MA',
          'BillingZipcode' => '02134',
          'BillingCountry' => 'US'
        ],
        'Application' => [
          'ApplicationID' => 'a123415'
        ]
      ],
    ];

    return $key ? $set[$key] : $set;
  }
}
