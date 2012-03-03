<?php

/**
 * Blacklist.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Log_Filter_Blacklist
 *
 * @uses Zend_Log_Filter_Interface
 * @package Dk
 * @subpackage LogFilters
 */
class Dk_Log_Filter_Blacklist implements Zend_Log_Filter_Interface
{
	/**
	 * @access protected
	 * @var array The accepted priorities
	 */
	protected $_priorities = array();
	
	/**
	 * __construct
	 * 
	 * @access public
	 * @param array $priorities The priorities we want
	 */
	public function __construct( array $priorities )
	{
		$this->_priorities = $priorities;
	}
	
	/**
	 * accept
	 * 
	 * Implementation of Zend_Log_Filter_Interface
	 * 
	 * @access public
	 */
	public function accept( $event )
	{
		$priority = strtolower( $event['priorityName'] );
		return !in_array( $priority, $this->_priorities );
	}
}
