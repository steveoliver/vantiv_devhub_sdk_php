<?php
/**
 * @file
 * Contains Vantiv\Base.
 */

namespace Vantiv;

abstract class Base {

  protected $_attributes = [];

  /**
   * @ignore
   * Don't permit an explicit call of the constructor.
   */
  protected function __construct() {}

  /**
   * @ignore
   * Disable cloning of objects.
   */
  protected function __clone() {}

  /**
   * Accessor for instance properties stored in the private $_attributes property
   *
   * @ignore
   * @param string $name
   * @return mixed
   */
  public function __get($name) {
    if (array_key_exists($name, $this->_attributes)) {
      return $this->_attributes[$name];
    }
    else {
      trigger_error('Undefined property on ' . get_class($this) . ': ' . $name, E_USER_NOTICE);
      return null;
    }
  }

  /**
   * Checks for the existence of a property stored in $_attributes.
   *
   * @ignore
   * @param string $name
   * @return boolean
   */
  public function __isset($name) {
    return array_key_exists($name, $this->_attributes);
  }

  /**
   * Mutator for instance properties stored in the private $_attributes.
   *
   * @ignore
   * @param string $key
   * @param mixed $value
   */
  public function _set($key, $value) {
    $this->_attributes[$key] = $value;
  }

}
