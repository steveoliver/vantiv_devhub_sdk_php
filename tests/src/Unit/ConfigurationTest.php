<?php
/**
 * @file
 * Unit tests for the Vantiv\Configuration class.
 */

namespace Vantiv\Test\Unit;

use Vantiv\Configuration;

class ConfigurationTest extends \PHPUnit_Framework_TestCase {

  protected $_config = NULL;

  /**
   * @expectedException Exception
   */
  public function testMissingApiVersion() {
    $this->_config = new Configuration([
      'license' => 'BBB',
      'base_url' => 'https://localhost'
    ]);
  }

  /**
   * @expectedException Exception
   */
  public function testMissingBaseUrl() {
    $this->_config = new Configuration([
      'api_version' => 1,
      'license' => 'BBB'
    ]);
  }

  /**
   * @expectedException Exception
   */
  public function testMissingLicense() {
    $this->_config = new Configuration([
      'api_version' => 1,
      'base_url' => 'https://localhost',
    ]);
  }

}
