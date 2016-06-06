<?php
/**
 * @file
 * Integration tests for the Vantiv\Request\Credit\Sale class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Sale;

/**
 * Class SaleIntegrationTest
 * @package Vantiv\Test\Integration
 * @group Integration
 */
class SaleIntegrationTest extends \PHPUnit_Framework_TestCase {

  /** @var Configuration */
  protected $_config = NULL;

  protected function setUp() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'https://apis.cert.vantiv.com',
      'license' => getenv('VANTIV_DEVHUB_LICENSE') ?: 'AAA'
    ]);
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
    $response = $saleResponse->getResponse();
    $this->assertTrue($result['http_code'] == 200);
    $this->assertObjectHasAttribute('response', $saleResponse);
    $this->assertEquals('Approved', $response->message);
    $this->assertEquals('11111 ', $response->authCode);
  }

}
