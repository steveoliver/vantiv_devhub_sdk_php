<?php
/**
 * @file
 * Tokenization certification tests (L_T_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request\Check\Sale as CheckSale;
use Vantiv\Request\Check\CheckReturn;
use Vantiv\Request\Credit\Authorization;
use Vantiv\Request\Services\PaymentAccountCreate;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

/**
 * Class TokenTest
 * @package Vantiv\Test\Certification
 * @group Certification
 */
class TokenTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_T_';
    $outfile = 'build/logs/devhubresults_L_T.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  /**
   * Tests successful payment account creation with Visa without CVV without AVS.
   */
  public function test_L_T_1() {
    $request = new PaymentAccountCreate($this->config);
    $body = $this->data('PaymentAccountCreate1');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('1', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertContains($response->response, [
      801,
      802
    ]);
    $this->assertContains($response->bin, [
      445711,
      445701
    ]);
//    $this->assertEquals('xxxxxxxxxxxx0123', $response->PaymentAccountID);
    $this->assertEquals('VI', $response->Type);
    $this->assertContains($response->message, [
      'Account number was successfully registered',
      'Account number was previously registered'
    ]);
  }

  /**
   * Tests failed payment account creation with Visa (Invalid credit card number).
   */
  public function test_L_T_2() {
    $request = new PaymentAccountCreate($this->config);
    $body = $this->data('PaymentAccountCreate2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('2', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(820, $response->response);
    $this->assertEquals('Credit card number was invalid', $response->message);
  }

  /**
   * Tests failed payment account creation with Visa (Account number previously registered).
   */
  public function test_L_T_3() {
    $request = new PaymentAccountCreate($this->config);
    $body = $this->data('PaymentAccountCreate3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('3', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(802, $response->response);
    $last4 = substr($body['Card']['AccountNumber'], -4);
    $this->assertTrue(substr($response->PaymentAccountID, -4) == $last4);
    $this->assertEquals(445711, $response->bin);
    $this->assertEquals('Account number was previously registered', $response->message);
  }

  /**
   * Tests successful payment account creation with Checking account.
   */
  public function test_L_T_4() {
    $request = new PaymentAccountCreate($this->config);
    $body = $this->data('PaymentAccountCreate4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('4', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertContains($response->response, [801, 802]);
    $this->assertEquals(998, $response->eCheckAccountSuffix);
    $this->assertContains($response->message, ['Account number was successfully registered','Account number was previously registered']);
    $this->assertEquals('EC', $response->Type);
  }

  /**
   * Tests failed payment account creation with Checking account (Invalid routing number).
   */
  public function test_L_T_5() {
    $request = new PaymentAccountCreate($this->config);
    $body = $this->data('PaymentAccountCreate5');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('5', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(900, $response->response);
    $this->assertEquals('Invalid Bank Routing Number', $response->message);
  }

  /**
   * Tests successful payment account creation with MasterCard authorization.
   */
  public function test_L_T_6() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization6');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('6', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals(000, $response->response);
    $this->assertContains($response->tokenResponse->tokenResponseCode, [801, 802]);
    $this->assertEquals(543510, $response->tokenResponse->bin);
    $this->assertEquals(1112000188100196, $response->tokenResponse->PaymentAccountID);
    $this->assertContains($response->tokenResponse->tokenMessage, ['Account number was successfully registered','Account number was previously registered']);
  }

  /**
   * Tests failed payment account creation with MasterCard authorization (Invalid account number).
   */
  public function test_L_T_7() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization7');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('7', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Invalid Account Number', $response->message);
    $this->assertEquals(301, $response->response);
  }

  /**
   * Tests failed payment account creation but successful MasterCard authorization (Account previously registered).
   */
  public function test_L_T_8() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization8');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('8', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(802, $response->tokenResponse->tokenResponseCode);
    $this->assertEquals('MC', $response->tokenResponse->Type);
    $this->assertEquals(543510, $response->tokenResponse->bin);
    $this->assertEquals(1112000188100196, $response->tokenResponse->PaymentAccountID);
    $this->assertEquals('Account number was previously registered', $response->tokenResponse->tokenMessage);
    return $response->tokenResponse->PaymentAccountID;
  }

  /**
   * Tests successful authorization with PaymentAccountID from test_L_T_8.
   *
   * @depends test_L_T_8
   */
  public function test_L_T_9($paymentAccountID) {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization9');
    // Add PaymentAccount from previous authorization / account creation.
    // PaymentAccountID used instead of Card.CardNumber.
    $body['PaymentAccount'] = ['PaymentAccountID' => $paymentAccountID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('9', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals(000, $response->response);
  }

  /**
   * Tests failed authorization using wrong PaymentAccountID (Token not found).
   */
  public function test_L_T_10() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization10');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('10', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(822, $response->response);
    $this->assertEquals('Token was not found', $response->message);
  }

  /**
   * Tests failed authorization using wrong PaymentAccountID (Token not found).
   */
  public function test_L_T_11() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization11');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('11', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(823, $response->response);
    $this->assertEquals('Token was invalid', $response->message);
  }

  /**
   * Tests successful payment account creation with eCheck sale transaction.
   */
  public function test_L_T_12() {
    $request = new CheckSale($this->config);
    $body = $this->data('Sale12');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('12', $requestID);
    echo "L_T_12";
    var_dump($response);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(801, $response->tokenResponseCode);
    $this->assertEquals(003, $response->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->tokenResponse->tokenMessage);
  }

  /**
   * Tests successful payment account creation with eCheck sale transaction.
   */
  public function test_L_T_13() {
    $request = new CheckSale($this->config);
    $body = $this->data('Sale13');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('13', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(801, $response->tokenResponse->tokenResponseCode);
    $this->assertEquals(999, $response->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->tokenResponse->tokenMessage);
  }

  /**
   * Tests successful payment account creation with eCheck return transaction.
   */
  public function test_L_T_14() {
    $request = new CheckReturn($this->config);
    $body = $this->data('Return14');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('14', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Transaction Received', $response->message);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(801, $response->tokenResponse->tokenResponseCode);
    $this->assertEquals(999, $response->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->tokenResponse->tokenMessage);
  }

  /**
   * Tests successful payment account creation with eCheck sale transaction.
   */
  public function test_L_T_15() {
    $request = new CheckSale($this->config);
    $body = $this->data('Sale15');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->logger->log('15', $requestID);
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals(000, $response->response);
    $this->assertEquals(801, $response->tokenResponse->tokenResponseCode);
    $this->assertEquals(993, $response->tokenResponse->eCheckAccountSuffix);
    $this->assertEquals('EC', $response->tokenResponse->Type);
    $this->assertEquals('Account number was successfully registered', $response->tokenResponse->tokenMessage);
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
