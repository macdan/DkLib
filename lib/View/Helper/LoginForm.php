<?php

/**
 * LoginForm.php
 * 
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_View_Helper_LoginForm
 * 
 * @uses Zend_View_Helper_Abstract
 * @package Dk
 * @subpackage Auth
 */
class Dk_View_Helper_LoginForm extends Zend_View_Helper_Abstract
{
	/**
	 * loginForm
	 * 
	 * Return the login form instance held in the auth resource
	 *
	 * @return Zend_Form The login form
	 */
	public function loginForm()
	{
		return Zend_Controller_Front::getInstance()
			->getParam( 'bootstrap' )
			->getResource( 'auth' )
			->getLoginForm();
	}
}
