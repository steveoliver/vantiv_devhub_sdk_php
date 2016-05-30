<?php
/**
 * @file
 * Contains Vantiv\Test\DevHubCertificationTestLogger.
 */

namespace Vantiv\Test;

class DevHubCertificationTestLogger {

  protected $prefix = '';
  protected $outfile = '';

  function __construct($prefix, $outfile) {
    $this->prefix = $prefix;
    $this->outfile = $outfile;
    file_put_contents(
      $outfile,
      'Test results for ' . $prefix . '* test suite.' . PHP_EOL . str_repeat('=', 44) . PHP_EOL
    );
  }

  public function log($testId, $requestId) {
    $message = $this->prefix . $testId . ',' . $requestId . PHP_EOL;
    file_put_contents($this->outfile, $message, FILE_APPEND);
  }

}
