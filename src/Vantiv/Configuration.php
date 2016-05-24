<?php
/**
 * @file
 * Contains Vantiv\Configuration.
 */

namespace Vantiv;

use Vantiv\Base;

class Configuration extends Base {

  /**
   * Constructor.
   *
   * @param array $config Configuration values, expecting these keys:
   *   - 'api_version': The API version, i.e. '1'.
   *   - 'base_url': The API base url, i.e. 'https://apis.cert.vantiv.com'.
   *   - 'license': The application license key obtained from DevHub.
   *
   * @throws \Exception When any of the required keys above are missing.
   */
  function __construct($config = array()) {
    if (empty($config['api_version'])) {
      throw new \Exception('Error: missing api_version. Please initialize this Request with a valid api_version.');
    }
    if (empty($config['base_url'])) {
      throw new \Exception('Error: missing base_url. Please initialize this Request with a valid base_url.');
    }
    if (empty($config['license'])) {
      throw new \Exception('Error: missing license. Please initialize this Request with a valid license.');
    }
    $this->_attributes = $config;
  }

}
