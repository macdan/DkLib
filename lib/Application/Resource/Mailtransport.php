<?php

/**
 * Mailtransport.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk Resource Mail Transport
 *
 * @uses Zend_Application_Resource_ResourceAbstract
 * @package Dk
 * @subpackage Mail
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */
class Dk_Application_Resource_Mailtransport extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * Init
	 *
	 * Initialise a Zend_Mail_Transport object and assign
	 * it as the 'mailtransport' application resource.
	 *
	 * @access public
	 * @return Zend_Mail_Transport_Abstract The mail transport
	 */
	public function init()
	{
		$options = $this->getOptions();
		$transportOptions = ( isset( $options['options'] ) ? $options['options'] : array() );
		
		switch ( $options['class'] )
		{
			case 'Zend_Mail_Transport_Sendmail':
				return new Zend_Mail_Transport_Sendmail( $transportOptions );
			
			case 'Zend_Mail_Transport_Smtp':
				return new Zend_Mail_Transport_Smtp( $options['host'], $transportOptions );
			
			default:
				throw new Dk_Application_Resource_Exception(
					'Invalid mail transport class provided'
				);
				
		}
	}
}
