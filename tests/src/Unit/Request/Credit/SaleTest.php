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

  public function testResponseObject() {
    $request = new Sale($this->_config);
    $result = $request->send([
      'Credentials' => [ ],
      'Reports' => [ ],
      'Transaction' => [ ],
      'Application' => [ ]
    ]);
    $response = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\SaleResponse', $response);
  }

}
