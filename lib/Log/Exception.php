<?php

/**
 * Exception.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Log_Exception
 *
 * @uses Dk_Exception
 * @package Dk
 */
class Dk_Log_Exception extends Dk_Exception
{
	const UNKNOWN_WRITER = 1;
	const UNKNOWN_FILTER = 2;
	const UNKNOWN_FORMATTER = 3;
}
