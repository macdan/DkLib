<?php

/**
 * Authed.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_View_Helper_Authed
 * 
 * @uses Zend_View_Helper_Abstract
 * @package Dk
 * @subpackage Auth
 */
class Dk_View_Helper_Authed extends Zend_View_Helper_Abstract
{
	/**
	 * authed
	 *
	 * Consult the auth resource to see if there is an active identity.
         * Return it if there is, otherwise return null.
         * 
         * @access public
         * @return mixed Active auth identity, otherwise null
	 */
	public function authed()
	{
		$auth = Zend_Controller_Front::getInstance()
			->getParam( 'bootstrap' )
			->getResource( 'auth' );

		if ( !$auth->hasIdentity() )
		{
			return null;
		}

		return $auth->loadIdentity();
	}
}
