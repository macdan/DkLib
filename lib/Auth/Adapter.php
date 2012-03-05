<?php

/**
 * Adapter.php
 * 
 * @author Daniel Kendell <daniel.kendell@gmail.com> 
 */

/**
 * Dk_Auth_Adapter
 * 
 * @package Dk
 * @subpackage Auth 
 */
interface Dk_Auth_Adapter
{
	/**
	 * setRequest
	 * 
	 * Allows the controller request object to be passed directly to the auth
	 * adapter, meaning nothing outside the adapter needs to know what parameters
	 * are used for authentication.
	 * 
	 * @access public
	 * @param Zend_Controller_Request_Abstract $request The controller request
	 */
	public function setRequest( Zend_Controller_Request_Abstract $request );
}
