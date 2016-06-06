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
    if (getenv('VANTIV_DEVHUB_LICENSE')) {
      $config_array = [
        'api_version' => 1,
        'base_url' => 'https://apis.cert.vantiv.com',
        'license' => getenv('VANTIV_DEVHUB_LICENSE')
      ];
      $this->config = new TestConfiguration($config_array);
    }
    else {
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

}
