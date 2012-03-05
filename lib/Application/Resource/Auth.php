<?php

/**
 * Auth.php
 * 
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Application_Resource_Auth
 * 
 * An application resource for initialising and configuring Auth, including
 * the auth adapter, login form (see Dk_View_Helper_LoginForm) and redirects
 * to take on auth (if any).
 *
 * @uses Zend_Application_Resource_ResourceAbstract
 * @uses Dk_Config
 * @uses Dk_Auth
 * @uses Dk_Log_Loggable
 * @package Dk
 * @subpackage Auth
 */
class Dk_Application_Resource_Auth extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * @access protected
	 * @var array Auth resource config
	 */
	protected $_config;

	/**
	 * init
         * 
         * Initialises the Auth resource. 
	 *
	 * @access public
	 * @return Dk_Auth The Dk_Auth instance
	 */
	public function init()
	{
		$this->_config = $this->getOptions();

		if ( isset( $this->_config['config'] ) )
		{
			$this->_config = Dk_Config::factory( $this->_config['config'], APPLICATION_ENV )
				->toArray();
		}

		$bootstrap = $this->getBootstrap();
		$auth = Dk_Auth::getInstance();

		// Set Auth Adapter
		$class = $this->_config['classes']['authAdapter'];
		$adapter = new $class;
		
		if ( $adapter instanceof Dk_Log_Loggable && $bootstrap->hasResource( 'log' ) )
		{
			$adapter->setLog( $bootstrap->getResource( 'log' ) );
		}

		$auth->setAuthAdapter( $adapter );

		// Set Login Form
		$class = $this->_config['classes']['loginForm'];
		$form = new $class;
		$auth->setLoginForm( $form );

		// Set the redirects
		if ( isset( $this->_config['redirect'] ) )
		{
			$auth->setRedirects( $this->_config['redirect'] );
		}

		return $auth;
	}
}
