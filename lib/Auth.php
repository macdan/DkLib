<?php

/**
 * Auth.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Auth
 *
 * @package Dk
 * @subpackage Auth
 */
class Dk_Auth extends Zend_Auth
{
	/**
	 * @access protected
	 * @var Zend_Auth_Adapter The auth adapter instance
	 */
	protected $_authAdapter;

	/**
	 * @access protected
	 * @var mixed The authed user instance
	 */
	protected $_authed;

	/**
	 * @access protected
	 * @var array The redirect config
	 */
	protected $_redirects;

	/**
	 * Get Instance
	 *
	 * @static
	 * @access public
	 * @return Dk_Auth The instance of Dk_Auth
	 */
	public static function getInstance()
	{
		if ( !self::$_instance )
		{
			self::$_instance = new self;
		}

		return self::$_instance;
	}

	/**
	 * Set Auth Adapter
	 *
	 * Accessor for the Auth adapter
	 *
	 * @access public
	 * @param Zend_Auth_Adapter $adapter The Zend_Auth_Adapter to use
	 * @return null
	 */
	public function setAuthAdapter( Zend_Auth_Adapter_Interface $adapter )
	{
		$this->_authAdapter = $adapter;
	}

	/**
	 * Get Auth Adapter
	 *
	 * Accessor for the Auth adapter
	 *
	 * @access public
	 * @return Zend_Auth_Adapter The adapter instance
	 */
	public function getAuthAdapter()
	{
		if ( !$this->_authAdapter )
		{
			throw new Dk_Auth_Exception(
				'No auth adapter',
				Dk_Auth_Exception::NO_AUTH_ADAPTER
			);
		}

		return $this->_authAdapter;
	}

	/**
	 * Set Login Form
	 *
	 * @access public
	 * @param Zend_Form $form The login form
	 * @return null
	 */
	public function setLoginForm( Zend_Form $form )
	{
		$this->_loginForm = $form;
	}

	/**
	 * Get Login Form
	 *
	 * @access public
	 * @return Zend_Form The login form
	 */
	public function getLoginForm()
	{
		if ( !$this->_loginForm )
		{
			throw new Dk_Auth_Exception(
				'No login form',
				Dk_Auth_Exception::NO_LOGIN_FORM
			);
		}

		return $this->_loginForm;
	}

	/**
	 * Get Identity
	 *
	 * @access public
	 * @return mixed The authed user instance
	 */
	public function getIdentity()
	{
		return $this->_authAdapter->getAuthed();
	}

	/**
	 * Set Redirects
	 *
	 * @access public
	 * @param array $redirects Array of redirect configuration
	 * @return null
	 */
	public function setRedirects( array $redirects )
	{
		$this->_redirects = $redirects;
	}

	/**
	 * Get Redirect
	 *
	 * @access public
	 * @param string $redirect The name of the redirect to get
	 * @return array Redirect config
	 */
	public function getRedirect( $redirect )
	{
		if ( !$this->hasRedirect( $redirect ) )
		{
			throw new Dk_Auth_Exception(
				"The $redirect redirect hasn't been configured",
				Dk_Auth_Exception::NO_REDIRECT
			);
		}
		
		return $this->_redirects[ $redirect ];
	}

	/**
	 * Get Redirects
	 *
	 * @access public
	 * @return array Array of redirect configuration
	 */
	public function getRedirects()
	{
		return $this->_redirects;
	}

	/**
	 * Has Redirect
	 *
	 * @access public
	 * @param string $redirect The redirect name
	 * @return boolean Whether or not the redirect has been configured
	 */
	public function hasRedirect( $redirect )
	{
		return isset( $this->_redirects[ $redirect ] );
	}

	/**
	 * Auth
	 *
	 * Just activate a session for the user provided, skipping the auth adapter
	 *
	 * @access public
	 * @param Dk_User $user The user to be authed
	 * @return null
	 */
	public function auth( Dk_User $user )
	{
		$this->getStorage()->write( $user->id );
	}
}
