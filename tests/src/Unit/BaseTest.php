<?php
/**
 * @file
 * Unit tests for the Vantiv\Base class.
 */

namespace Vantiv\Test\Unit;

use Vantiv\Configuration;

class BaseTest extends \PHPUnit_Framework_TestCase {

  protected $_config = NULL;

  private $errors;

  protected function setUp() {
    $this->errors = array();
    set_error_handler(array($this, "errorHandler"));
  }

  public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext) {
    $this->errors[] = compact("errno", "errstr", "errfile",
      "errline", "errcontext");
  }

  public function assertError($errstr, $errno) {
    foreach ($this->errors as $error) {
      if ($error["errstr"] === $errstr
        && $error["errno"] === $errno) {
        return;
      }
    }
    $this->fail("Error with level " . $errno .
      " and message '" . $errstr . "' not found in ",
      var_export($this->errors, TRUE));
  }

  public function testBaseAttributes() {
    $this->_config = new Configuration([
      'api_version' => '1',
      'base_url' => 'http://example.com',
      'license' => 'AAA'
    ]);

    $this->assertNull($this->_config->foo, 'undefined property foo is null');
    $this->assertError('Undefined property on Vantiv\Configuration: foo', E_USER_NOTICE);
    $this->assertFalse(isset($this->_config->foo));
    $this->_config->_set('foo', 'bar');
    $this->assertEquals($this->_config->foo, 'bar');
  }

}
