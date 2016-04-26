<?php
/**
 * @file
 * Vantiv Test Configuration
 */

namespace Vantiv\Test;

class Config {

  public $config = [];

  public function __construct() {
    $config = realpath(dirname(__FILE__)) . '/config.ini';
    if (file_exists($config)) {
      $config_array = parse_ini_file($config);
      $this->config = $config_array;
    }
    else {
      $this->config = [
        'api_version' => 1,
        'base_url' => 'https://apis.cert.vantiv.com',
        'license' => ''
      ];
    }
  }

}
