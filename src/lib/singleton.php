<?php
namespace DirListing;

abstract class Singleton {

	protected static $_instance = [];

	protected function  __construct() { }

	protected function _init() { }

	final private function  __clone() { }

	final public static function Instance() {
		$class = get_called_class();
		if ( ! isset( static::$_instance[ $class ] ) ) {
			self::$_instance[ $class ] = new $class();
			self::$_instance[ $class ]->_init();
		}
		return self::$_instance[ $class ];
	}
}

// EOF
