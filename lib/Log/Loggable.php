<?php

/**
 * Loggable.php
 * 
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Log_Loggable
 *
 * A very simple interface simply to indicate that an object can accept and use
 * an instance of Zend_Log.
 * 
 * @category Dk
 * @package Log
 * @uses Zend_Log
 */
interface Dk_Log_Loggable
{
	/**
	 * Set Log
	 *
	 * Setter for the Zend_Log instance
	 * 
	 * @access public
	 * @param Zend_Log $log The Zend_Log instance
	 * @return void
	 */
	public function setLog( Zend_Log $log );
}
