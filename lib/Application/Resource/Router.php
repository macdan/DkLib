<?php

/**
 * Router.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Application_Resource_Router
 *
 * @uses Zend_Application_Resource_Router
 * @uses Dk_Config
 * @package Dk
 * @subpackage Router
 */
class Dk_Application_Resource_Router extends Zend_Application_Resource_Router
{
	/**
	 * Initialise Router
	 *
	 * @access public
	 * @return null
	 */
	public function init()
	{
		$router = $this->getRouter();
		$config = $this->getOptions();
		
		if ( isset( $config['config'] ) )
		{
			$config = Dk_Config::factory( $config['config'], APPLICATION_ENV );
		}
		else
		{
			$config = Dk_Config::factory( $config );
		}
		
		$router->addConfig( $config );

		return $router;
	}
}
