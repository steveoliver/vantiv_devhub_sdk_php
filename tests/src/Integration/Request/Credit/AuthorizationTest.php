<?php
/**
 * @file
 * Integration tests for the Vantiv\Request\Credit\Authorization class.
 */

namespace Vantiv\Test\Integration;

use Vantiv\Configuration;
use Vantiv\Request\Credit\Authorization;

/**
 * Class AuthorizationIntegrationTest
 * @package Vantiv\Test\Integration
 * @group Integration
 */
class AuthorizationIntegrationTest extends \PHPUnit_Framework_TestCase {

  /** @var Configuration */
  protected $_config = NULL;

  protected function setUp() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'https://apis.cert.vantiv.com',
      'license' => getenv('VANTIV_DEVHUB_LICENSE') ?: 'AAA'
    ]);
  }

  public function testBadAuthRequest() {
    $config = $this->_config;
    $auth = new Authorization($config);
    $result = $auth->send([
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
      'Application' => [
        'ApplicationID' => 's12341'
      ]
    ]);
    $this->assertFalse($result['response']->success());
    $this->assertEquals($result['response']->failure(), 'Must have exactly one of the following values: "card","paypal","paypage","token","applepay"');
    $this->assertEquals($result['http_code'], '500');
  }

}
