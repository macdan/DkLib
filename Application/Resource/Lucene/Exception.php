<?php

/**
 * Exception.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Application_Resource_Lucene_Exception
 *
 * @package Dk
 * @subpackage ApplicationResources
 * @uses Dk_Exception
 * @see Dk_Application_Resource_Lucene
 */
class Dk_Application_Resource_Lucene_Exception extends Dk_Exception
{
	/**
	 * No path to an index file was specified
	 */
	const NO_INDEX_PATH = 1;

	/**
	 * No path to an index file was found
	 */
	const NO_INDEX_FOUND = 2;
}
