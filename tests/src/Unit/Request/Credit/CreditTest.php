<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Credit class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Credit;

/**
 * Class CreditUnitTest
 * @package Vantiv\Test\Unit\Request\Credit
 * @group Unit
 */
class CreditUnitTest extends \PHPUnit_Framework_TestCase {

  /** @var Configuration */
  protected $_config = NULL;

  protected function setUp() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'https://apis.cert.vantiv.com',
      'license' => getenv('VANTIV_DEVHUB_LICENSE') ?: 'AAA'
    ]);
  }

  /**
   * Tests constructed properties of Credit request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $auth = new Credit($config);

    $this->assertEquals($auth->getCategory(), 'payment');
    $this->assertEquals($auth->getProxy(), 'credit');
    $this->assertEquals($auth->getEndpoint(), 'credit');
    $this->assertEquals($auth->getMethod(), 'POST');
  }

  public function testResponseObject() {
    $request = new Credit($this->_config);
    $result = $request->send([
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
        'ApplicationID' => 's12347'
      ]
    ]);
    $response = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\Credit\CreditResponse', $response);
  }

}
