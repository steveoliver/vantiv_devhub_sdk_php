<?php
/**
 * @file
 * Authorization and capture certification tests (L_AC_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Request\Credit\Authorization;
use Vantiv\Request\Credit\AuthorizationCompletion;
use Vantiv\Test\DevHubCertificationTestLogger;
use Vantiv\Test\Configuration;

class AuthorizationCaptureTest extends \PHPUnit_Framework_TestCase {
  
  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_AC_';
    $outfile = 'build/logs/devhubresults_L_AC.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  public function test_L_AC_1() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization1');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->logger->log('1', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AC_1
   */
  public function test_L_AC_1A($TransactionID) {
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
  }

  public function test_L_AC_2() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization2');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->logger->log('2', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AC_2
   */
  public function test_L_AC_2A($TransactionID) {
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
  }

  public function test_L_AC_3() {
    $request = new Authorization($this->config);
    $body = $this->data('Authorization3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AC_3
   */
  public function test_L_AC_3A($TransactionID) {
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
  }

  public function test_L_AC_4() {
    $request = new Authorization($this->config);
    $result = $request->send($this->data('Authorization4'));
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(000, $response->response);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AC_4
   */
  public function test_L_AC_4A($TransactionID) {
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
  }

  public function test_L_AC_5() {
    $request = new Authorization($this->config);
    $result = $request->send($this->data('Authorization5'));
    $this->assertEquals(200, $result['http_code']);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(000, $response->response);
    $this->logger->log('5', $requestID);
    return $response->TransactionID;
  }

  /**
   * @depends test_L_AC_5
   */
  public function test_L_AC_5A($TransactionID) {
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
  }

  public function test_L_AC_6() {
    $request = new Authorization($this->config);
    $body = $this->data('InsufficientFunds');
    $result = $request->send($body);
    $this->assertEquals(200, $result['http_code']);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(110, $response->response);
    $this->assertEquals('Insufficient Funds', $response->message);
    $this->logger->log('6', $requestID);
  }

  public function test_L_AC_7() {
    $request = new Authorization($this->config);
    $body = $this->data('InvalidAccountNumber');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(301, $response->response);
    $this->assertEquals('Invalid Account Number', $response->message);
    $this->logger->log('7', $requestID);
  }

  public function test_L_AC_8() {
    $request = new Authorization($this->config);
    $body = $this->data('CallDiscover');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(123, $response->response);
    $this->assertEquals('Call Discover', $response->message);
    $this->logger->log('8', $requestID);
  }

  public function test_L_AC_9() {
    $request = new Authorization($this->config);
    $body = $this->data('PickUpCard');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(303, $response->response);
    $this->assertEquals('Pick Up Card', $response->message);
    $this->logger->log('9', $requestID);
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
