<?php

/**
 * Config.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Config
 *
 * Adds a static factory() method to Zend_Config
 *
 * @uses Zend_Config
 * @package Dk
 */
class Dk_Config extends Zend_Config
{
	/**
	 * Factory
	 *
	 * @static
	 * @access public
	 * @param mixed $conf Config source, can be an array or path to an ini or xml file
	 * @param string $env Optional: The environment block to use
	 * @return Dk_Config object
	 */
	public static function factory( $conf, $env=null )
	{
		if ( is_array( $conf ) )
		{
			return new Zend_Config( $conf, $env );
		}

		if ( is_string( $conf ) )
		{
			switch ( pathinfo( $conf, PATHINFO_EXTENSION ) )
			{
				case 'ini':
					return new Zend_Config_Ini( $conf, $env );
					break;

				case 'xml':
					return new Zend_Config_Xml( $conf, $env );
					break;

				default:
					throw new Dk_Config_Exception(
						'Unknown config file type',
						Dk_Config_Exception::UNKNOWN_CONFIG_TYPE
					);
					break;
			}
		}
	}
}
