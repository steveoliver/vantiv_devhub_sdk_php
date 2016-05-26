<?php
/**
 * @file
 * Contains the Vantiv\Request class.
 */

namespace Vantiv;

use Exception;
use Vantiv\Configuration;

class Request {

  private $config = NULL;
  private $uri = '';
  private $category = '';
  private $proxy = '';
  private $endpoint = '';
  private $method = '';
  private $query = array();
  private $body = array();

  /**
   * Request constructor.
   *
   * @param Configuration $config An initialized Configuration object.
   */
  function __construct(Configuration $config) {
    $this->config = $config;
  }

  /**
   * @return array Required elements for any API request.
   */
  public function getRequiredElements() {
    return [
      'Credentials', 'Reports', 'Transaction', 'Application'
    ];
  }

  /**
   * Sets the transaction type from multiple request parameters at once.
   *
   * @param string $category
   * @param string $proxy
   * @param string $endpoint
   * @param string $method
   * @param array $query
   *
   * @return $this
   */
  public function setTransactionType($category, $proxy, $endpoint, $method, $query) {
    $this
      ->setCategory($category)
      ->setProxy($proxy)
      ->setEndpoint($endpoint)
      ->setMethod($method)
      ->setQuery($query)
      ->constructUri();
    return $this;
  }

  /**
   * Constructs this instance's uri property from the current config and values.
   *
   * @return $this
   */
  public function constructUri() {
    $this->uri = implode('/', array(
      $this->config->base_url,
      $this->category,
      'sp2',
      $this->proxy,
      'v' . $this->config->api_version,
      $this->endpoint
    ));
    // GET requests append query to string.
    if ($this->method == 'GET' && !empty($this->query)) {
      $this->uri .= '?' . http_build_query($this->query);
    }
    return $this;
  }

  /**
   * Gets the uri property.
   *
   * @return string
   */
  public function getUri() {
    return $this->uri;
  }

  /**
   * Sets the API category property.
   *
   * @param string $category
   *   The category, e.g. 'payment', 'boarding', etc.
   *
   * @return $this
   */
  public function setCategory($category) {
    $this->category = $category;
    return $this;
  }

  /**
   * Gets the API category property.
   *
   * @return string
   */
  public function getCategory() {
    return $this->category;
  }

  /**
   * Sets the API proxy property.
   *
   * @param string $proxy
   *   The proxy, e.g. 'credit', 'check', 'services', etc.
   *
   * @return $this
   */
  public function setProxy($proxy) {
    $this->proxy = $proxy;
    return $this;
  }

  /**
   * Gets the API proxy property.
   *
   * @return string
   */
  public function getProxy() {
    return $this->proxy;
  }

  /**
   * Sets the API endpoint property.
   *
   * @param string $endpoint
   *   The endpoint, e.g. 'authorization', 'authorizationCompletion', 'credit',
   *   'sale', 'return', 'void', 'force', 'reversal', 'verification', etc.
   *
   * @return $this
   */
  public function setEndpoint($endpoint) {
    $this->endpoint = $endpoint;
    return $this;
  }

  /**
   * Gets the API endpoint property.
   *
   * @return string
   */
  public function getEndpoint() {
    return $this->endpoint;
  }

  /**
   * Sets the HTTP request method.
   *
   * @param string $method
   *   The HTTP method of the request.
   *
   * @return $this
   */
  public function setMethod($method) {
    $this->method = $method;
    return $this;
  }

  /**
   * Gets the API method property.
   *
   * @return string
   */
  public function getMethod() {
    return $this->method;
  }

  /**
   * Sets the API query property.
   *
   * @param array $query
   *   Query parameters to send with the request.
   *
   * @return $this
   */
  public function setQuery($query) {
    $this->query = $query;
    return $this;
  }

  /**
   * Gets the API query property.
   *
   * @return string
   */
  public function getQuery() {
    return $this->query;
  }

  /**
   * Delivers a request to the Vantiv DevHub REST API.
   *
   * @throws Exception if not all required elements are set in body.
   * @param array $body
   *   The request body.
   * @param string $category
   * @param string $proxy
   * @param string $endpoint
   * @param string $method
   * @param array $query
   * @return array Information about the request with the following keys:
   *   - 'response' The HTTP response body (JSON string).
   *   - 'http_code' The HTTP response status code.
   */
  public function send($body = [], $category = NULL, $proxy = NULL, $endpoint = NULL, $method = NULL, $query = []) {
    if ($missing_keys = array_diff(self::getRequiredElements(), array_keys($body))) {
      $missing_keys = implode(', ', array_values($missing_keys));
      throw new Exception($missing_keys . ' keys are missing from request.');
    }
    $this->body = $body;
    if (func_num_args() > 1) {
      $this->setTransactionType($category, $proxy, $endpoint, $method, $query);
    }
    else {
      $this->constructUri();
    }

    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      'Authorization: VANTIV license="' . $this->config->license . '"',
      'Content-Type: application/json',
      'Accept: application/json'
    ));

    if ($this->method != 'GET') {
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $this->method);
      $fields = $this->body;
      if (!empty($this->query)) {
        $fields = array_merge($fields, $this->query);
      }
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_URL, $this->uri);

    $response = curl_exec($ch);

    return [
      'response' => $response,
      'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE)
    ];
  }
}
