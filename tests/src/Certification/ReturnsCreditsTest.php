<?php
/**
 * @file
 * Returns and credits certification tests (L_RC_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request\Credit\Authorization;
use Vantiv\Request\Credit\AuthorizationCompletion;
use Vantiv\Request\Credit\Credit;
use Vantiv\Request\Credit\CreditReturn;
use Vantiv\Request\Credit\Sale;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

/**
 * Class ReturnsCreditsTest
 * @package Vantiv\Test\Certification
 * @group Certification
 */
class ReturnsCreditsTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_RC_';
    $outfile = 'build/logs/devhubresults_L_RC.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  /**
   * Tests authorization of Visa with CVV and AVS.
   */
  public function test_L_RC_1() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('11111 ', $response->authCode);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('1', $requestID);
    return $response->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_1
   */
  public function test_L_RC_1A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion1');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('1A', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_1A
   */
  public function test_L_RC_1B($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('1B', $requestID);
  }

  /**
   * Tests authorization of MasterCard with CVV and AVS.
   */
  public function test_L_RC_2() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('22222 ', $response->authCode);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('2', $requestID);
    return $response->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_2
   */
  public function test_L_RC_2A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion2');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('2A', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_2A
   */
  public function test_L_RC_2B($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit2');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('2B', $requestID);
  }

  /**
   * Tests authorization of Discover card with CVV and AVS.
   */
  public function test_L_RC_3() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('33333 ', $response->authCode);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals(10, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_3
   */
  public function test_L_RC_3A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion3');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('3A', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_3A
   */
  public function test_L_RC_3B($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit3');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('3B', $requestID);
  }

  /**
   * Tests authorization of American Express card with AVS without CVV.
   */
  public function test_L_RC_4() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('44444 ', $response->authCode);
    $this->assertEquals(13, $response->fraudResult->avsResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_4
   */
  public function test_L_RC_4A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion4');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('4A', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_4A
   */
  public function test_L_RC_4B($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit4');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('4B', $requestID);
  }

  /**
   * Tests authorization of Visa card with CVV without AVS.
   */
  public function test_L_RC_5() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('55555 ', $response->authCode);
    $this->assertEquals(32, $response->fraudResult->avsResult);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('5', $requestID);
    return $response->TransactionID;
  }

  /**
   * Captures the authorization transaction above.
   *
   * @depends test_L_RC_5
   */
  public function test_L_RC_5A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion5');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('5A', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the capture transaction above.
   *
   * @depends test_L_RC_5A
   */
  public function test_L_RC_5B($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit5');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('5B', $requestID);
  }

  /**
   * Tests Visa card sale with CVV and AVS.
   */
  public function test_L_RC_6() {
    $request = new Sale($this->config);
    $body = $this->data('Sale6');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('11111 ', $response->authCode);
    $this->assertEquals('M', $response->fraudResult->cardValidationResult);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('6', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the sale transaction above.
   *
   * @depends test_L_RC_6
   */
  public function test_L_RC_6A($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit6');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('6A', $requestID);
  }

  /**
   * Tests MasterCard sale with CVV and AVS.
   */
  public function test_L_RC_7() {
    $request = new Sale($this->config);
    $body = $this->data('Sale7');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('7', $requestID);
    return $response->TransactionID;
  }

  /**
   * Credits the sale transaction above.
   *
   * @depends test_L_RC_7
   */
  public function test_L_RC_7A($TransactionID) {
    $request = new Credit($this->config);
    $body = $this->data('Credit7');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('7A', $requestID);
  }

  /**
   * Tests Visa card return with CVV without AVS.
   */
  public function test_L_RC_8() {
    $request = new CreditReturn($this->config);
    $body = $this->data('Return8');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('8', $requestID);
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

  public function test() {
  }
}
