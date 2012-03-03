<?php

/**
 * Log.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Log
 *
 * Just add a couple of accessor methods.
 *
 * @uses Zend_Log
 * @category Dk
 * @package Log
 */
class Dk_Log extends Zend_Log
{
	/**
	 * Get Priorities
	 * 
	 * Accessor for the priorities array
	 *
	 * @access public
	 * @return array Log priorities
	 */
	public function getPriorities()
	{
		return $this->_priorities;
	}

	/**
	 * Has Priority
	 *
	 * Check whether or not a priority has been defined
	 *
	 * @access public
	 * @param string $name The name of the priority to check
	 * @return boolean Whether or not it has been defined
	 */
	public function hasPriority( $name )
	{
		return in_array( strtoupper( $name ), $this->_priorities );
	}
}
