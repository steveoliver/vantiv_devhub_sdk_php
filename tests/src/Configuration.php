<?php
/**
 * @file
 * Contains Vantiv\Test\Configuration.
 */

namespace Vantiv\Test;

use Vantiv\Configuration as TestConfiguration;

class Configuration {

  public $config = NULL;

  /**
   * Constructor.
   *
   * Initializes config with a Configuration object from tests/config.ini values.
   */
  function __construct() {
    $config = realpath(dirname(dirname(__FILE__))) . '/config.ini';
    if (file_exists($config)) {
      $config_array = parse_ini_file($config);
      $this->config = new TestConfiguration($config_array);
    }
    else {
      throw new \Exception("Error: missing test config.ini. Please copy tests/example.config.ini to tests/config.ini and customize with your app's license.");
    }
  }

}
