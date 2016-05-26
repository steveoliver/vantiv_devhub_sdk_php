<?php
/**
 * @file
 * Contains Vantiv\Response;
 */

namespace Vantiv;

/**
 * Class Response
 * @package Vantiv
 *
 * Default Response class.
 */
class Response {

  protected $response = NULL;

  function __construct($response) {
    $this->response = $response;
  }

  /**
   * @return stdClass The litleOnlineResponse element from a DevHub response object.
   */
  public function get() {
    $response = json_decode($this->response);
    return $response->litleOnlineResponse;
  }

}
