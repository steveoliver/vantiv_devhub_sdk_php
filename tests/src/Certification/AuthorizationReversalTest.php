<?php
/**
 * @file
 * Authorization reversal certification tests (L_AR_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request\Credit\Authorization;
use Vantiv\Request\Credit\AuthorizationCompletion;
use Vantiv\Request\Credit\Reversal;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

/**
 * Class AuthorizationReversalTest
 * @package Vantiv\Test\Certification
 * @group Certification
 */
class AuthorizationReversalTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_AR_';
    $outfile = 'build/logs/devhubresults_L_AR.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  public function test_L_AR_1() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('1', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AR_1
   */
  public function test_L_AR_1A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('1A', $requestID);
  }

  /**
   * @depends test_L_AR_1
   */
  public function test_L_AR_1B($TransactionID) {
    $request = new Reversal($this->config);
    $body = $this->data('AuthorizationReversal1');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('1B', $requestID);
  }

  public function test_L_AR_2() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('2', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AR_2
   */
  public function test_L_AR_2A($TransactionID) {
    $request = new Reversal($this->config);
    $body = $this->data('AuthorizationReversal2');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('2A', $requestID);
  }

  public function test_L_AR_3() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AR_3
   */
  public function test_L_AR_3A($TransactionID) {
    $request = new Reversal($this->config);
    $body = $this->data('AuthorizationReversal3');
    $body['Transaction'] = ['TransactionID' => $TransactionID];
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('3A', $requestID);
  }

  public function test_L_AR_4() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AR_4
   */
  public function test_L_AR_4A($TransactionID) {
    $request = new AuthorizationCompletion($this->config);
    $body = $this->data('AuthorizationCompletion4');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('4A', $requestID);
  }

  /**
   * @depends test_L_AR_4
   */
  public function test_L_AR_4B($TransactionID) {
    $request = new Reversal($this->config);
    $body = $this->data('AuthorizationReversal4');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('4B', $requestID);
  }

  public function test_L_AR_5() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization5');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->assertEquals('Approved', $response->message);
    $this->logger->log('5', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AR_5
   */
  public function test_L_AR_5A($TransactionID) {
    $request = new Reversal($this->config);
    $body = $this->data('AuthorizationReversal5');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('5A', $requestID);
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
