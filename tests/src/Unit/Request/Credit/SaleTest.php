<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Sale class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Sale;

class SaleTest extends \PHPUnit_Framework_TestCase {

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
   * Tests constructed properties of Sale request.
   */
  public function testConstructedProperties() {
    $sale = new Sale($this->_config);

    $this->assertEquals($sale->getCategory(), 'payment');
    $this->assertEquals($sale->getProxy(), 'credit');
    $this->assertEquals($sale->getEndpoint(), 'sale');
    $this->assertEquals($sale->getMethod(), 'POST');
  }

  public function testSaleResponse() {
    $sale = new Sale($this->_config);
    $result = $sale->send([
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
        'ApplicationID' => 's12342'
      ]
    ]);
    $saleResponse = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\SaleResponse', $saleResponse);
  }

  public function testSuccessfulSale() {
    $config = $this->_config;
    $sale = new Sale($config);
    $result = $sale->send([
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
        'ApplicationID' => 's12341'
      ]
    ]);
    $saleResponse = $result['response'];
    $response = $saleResponse->get();
    $this->assertTrue($result['http_code'] >= 200);
    $this->assertInstanceOf('Vantiv\Response\SaleResponse', $saleResponse);
    $this->assertObjectHasAttribute('response', $saleResponse);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('11111 ', $response->authCode);
  }

}
