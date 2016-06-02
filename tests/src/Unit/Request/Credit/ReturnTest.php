<?php
/**
 * @file
 * Unit tests for the Vantiv\Request\Credit\Return class.
 */

namespace Vantiv\Test\Unit\Request\Credit;

use Vantiv\Configuration;
use Vantiv\Request\Credit\CreditReturn;

class ReturnUnitTest extends \PHPUnit_Framework_TestCase {

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
   * Tests constructed properties of Return request.
   */
  public function testConstructedProperties() {
    $config = $this->_config;
    $auth = new CreditReturn($config);

    $this->assertEquals($auth->getCategory(), 'payment');
    $this->assertEquals($auth->getProxy(), 'credit');
    $this->assertEquals($auth->getEndpoint(), 'return');
    $this->assertEquals($auth->getMethod(), 'POST');
  }

  public function testResponseObject() {
    $request = new CreditReturn($this->_config);
    $result = $request->send([
      'Credentials' => [ ],
      'Reports' => [ ],
      'Transaction' => [ ],
      'Application' => [ ]
    ]);
    $response = $result['response'];
    $this->assertInstanceOf('Vantiv\Response\Credit\CreditReturnResponse', $response);
  }

}
