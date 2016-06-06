<?php
/**
 * @file
 * Void certification tests (L_V_*).
 */

namespace Vantiv\Test\Certification;

use Vantiv\Request;
use Vantiv\Request\Credit\Authorization;
use Vantiv\Request\Credit\AuthorizationCompletion;
use Vantiv\Request\Credit\Credit;
use Vantiv\Request\Credit\CreditReturn;
use Vantiv\Request\Credit\Sale;
use Vantiv\Request\Credit\Void;
use Vantiv\Test\Configuration;
use Vantiv\Test\DevHubCertificationTestLogger;

/**
 * Class VoidTest
 * @package Vantiv\Test\Certification
 * @group Certification
 */
class VoidTest extends \PHPUnit_Framework_TestCase {

  private $config = [];

  public function __construct() {
    $config = new Configuration();
    $this->config = $config->config;
    $prefix = 'L_V_';
    $outfile = 'build/logs/devhubresults_L_V.txt';
    $this->logger = new DevHubCertificationTestLogger($prefix, $outfile);
  }

  /**
   * Tests authorization of Visa with CVV and AVS.
   */
  public function test_L_V_1() {
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
   * @depends test_L_V_1
   */
  public function test_L_V_1A($TransactionID) {
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
   * @depends test_L_V_1A
   */
  public function test_L_V_1B($TransactionID) {
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
    return $response->TransactionID;
  }

  /**
   * Void the credit transaction above.
   *
   * @depends test_L_V_1B
   */
  public function test_L_V_1C($TransactionID) {
    $request = new Void($this->config);
    $body = $this->data('Void1');
    $body['Transaction']['TransactionID'] = $TransactionID;
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('1C', $requestID);
  }

  /**
   * Tests sale of MasterCard with CVV and AVS.
   */
  public function test_L_V_2() {
    $request = new Sale($this->config);
    $body = $this->data('Sale2');
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
   * Voids the sale transaction above.
   *
   * @depends test_L_V_2
   */
  public function test_L_V_2A($TransactionID) {
    $request = new Void($this->config);
    $body = $this->data('Void2');
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
   * Tests return transaction on Visa card with CVV and no AVS.
   */
  public function test_L_V_3() {
    $request = new CreditReturn($this->config);
    $body = $this->data('Return3');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(001, $response->response);
    $this->assertEquals('Transaction Received', $response->message);
    $this->logger->log('3', $requestID);
    return $response->TransactionID;
  }

  /**
   * Voids the return transaction above.
   *
   * @depends test_L_V_3
   */
  public function test_L_V_3A($TransactionID) {
    $request = new Void($this->config);
    $body = $this->data('Void3');
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
   * Tests Visa card sale with AVS and CVV (Insufficient Funds).
   */
  public function test_L_V_4() {
    $request = new Sale($this->config);
    $body = $this->data('Sale4');
    $result = $request->send($body);
    $response = $result['response']->getResponse();
    $requestID = $result['response']->getRequestID();
    $this->assertEquals(200, $result['http_code']);
    $this->assertEquals(110, $response->response);
    $this->assertEquals(34, $response->fraudResult->avsResult);
    $this->assertEquals('Insufficient Funds', $response->message);
    $this->logger->log('4', $requestID);
    return $response->TransactionID;
  }

  /**
   * Voids the sale transaction above.
   *
   * @depends test_L_V_4
   */
  public function test_L_V_4A($TransactionID) {
    $request = new Void($this->config);
    $body = $this->data('Void4');
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
