<?php

/**
 * Whitelist.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Log_Filter_Whitelist
 *
 * @package Dk
 * @subpackage Log
 */
class Dk_Log_Filter_Whitelist implements Zend_Log_Filter_Interface
{
	/**
	 * @access protected
	 * @var array The accepted priorities
	 */
	protected $_priorities = array();
	
	/**
	 * Construct
	 * 
	 * @access public
	 * @param array $priorities The priorities we want
	 */
	public function __construct( array $priorities )
	{
		$this->_priorities = $priorities;
	}
	
	/**
	 * Accept
	 * 
	 * Implementation of Zend_Log_Filter_Interface
	 * 
	 * @access public
	 */
	public function accept( $event )
	{
		$priority = strtolower( $event['priorityName'] );
		return in_array( $priority, $this->_priorities );
	}
}
