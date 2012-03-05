<?php

/**
 * Log.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Application_Resource_Log
 *
 * @uses Zend_Application_Resource_ResourceAbstract
 * @package Dk
 * @subpackage Log
 */
class Dk_Application_Resource_Log extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * Init
	 *
	 * Resource plugin initialisation
	 *
	 * @access public
	 * @return 
	 */
	public function init()
	{
		$config = $this->getOptions();

		if ( isset( $config['config'] ) )
		{
			$config = Dk_Config::factory( $config['config'], APPLICATION_ENV )
				->toArray();
		}
		
		$log = new Dk_Log;
		
		// Default writer
		$writers = array(
			array( 'class' => 'Zend_Log_Writer_Null' )
		);
		
		// We've got writing to do!
		if ( isset( $config['writer'] ) )
		{
			$writers = $config['writer'];
		}
		
		// If there's only one writer, make sure it's in an array
		if ( isset( $writers['class'] ) )
		{
			$writers = array( $writers );
		}
		
		// Add each writer
		foreach ( $writers as $writer )
		{
			$class = $writer['class'];
			$filters = ( isset( $writer['filter'] ) ? $writer['filter'] : null );
			$formatter = ( isset( $writer['formatter'] ) ? $writer['formatter'] : null );
			
			switch ( $class )
			{
				case 'Zend_Log_Writer_Stream':
					$stream = ( isset( $writer['stream'] ) ? $writer['stream'] : array() );
					
					// Path Parameter Shortcut
					$stream['path'] = ( isset( $writer['path'] ) ? $writer['path'] : $stream['path'] );
					
					// Params
					$path = ( isset( $stream['path'] ) ? $stream['path'] : null );
					$mode = ( isset( $stream['mode'] ) ? $stream['mode'] : 'a' );
					
					if ( !$path )
					{
						throw new Dk_Application_Resource_Exception(
							'No path to a log file was provided'
						);
					}
					
					$writer = new Zend_Log_Writer_Stream( $path, $mode );
					break;
				
				case 'Zend_Log_Writer_Syslog':
					$syslog = ( isset( $writer['syslog'] ) ? $writer['syslog'] : array() );
					$writer = new Zend_Log_Writer_Syslog( $syslog );
					break;
				
				case 'Zend_Log_Writer_Mail':
					$mail = ( isset( $writer['mail'] ) ? $writer['mail'] : array() );
					$config = $this->_bootstrap->getOption( 'email' );
					
					$fromAddr = $config['from']['address'];
					$fromName = $config['from']['name'];
					
					$to = ( !is_array( $mail['to'] ) ? array( $mail['to'] ) : $mail['to'] );
					
					$email = new Zend_Mail;
					$email->setFrom( $fromAddr, $fromName );
					
					foreach ( $to as $address )
					{
						$email->addTo( $address );
					}
					
					$writer = new Zend_Log_Writer_Mail( $email );
					break;
				
				case 'Zend_Log_Writer_Db':
					$db = ( isset( $writer['db'] ) ? $writer['db'] : null );
					$fieldMap = null;
					
					if ( $db['map'] )
					{
						foreach ( $db['map'] as $map )
						{
							$fieldMap[ $map['field'] ] = $map['property'];
						}
					}
					
					$conn = Zend_Db::factory( new Zend_Config( $db ) );
					$writer = new Zend_Log_Writer_Db( $conn, $db['params']['table'], $fieldMap );
					break;
				
				case 'Zend_Log_Writer_Null':
					$writer = new Zend_Log_Writer_Null;
					break;
				
				default:
					if ( class_exists( $class ) )
					{
						$writer = new $class;
						break;
					}

					throw new Dk_Log_Exception( 
						"Unknown log writer: $class", 
						Dk_Log_Exception::UNKNOWN_WRITER 
					);
					break;
			}
			
			// Add writer filters
			if ( $filters )
			{
				if ( isset( $filters['class'] ) )
				{
					$filters = array( $filters );
				}
				
				foreach ( $filters as $filter )
				{
					$class = $filter['class'];
					
					switch ( $class )
					{
						case 'Dk_Log_Filter_Whitelist':
						case 'Dk_Log_Filter_Blacklist':
							$parts = explode( '_', $class );
							$configKey = strtolower( array_pop( $parts ) );

							$priorities = array_keys( $filter[ $configKey ] );
							$filter = new $class( $priorities );
							break;
						
						case 'Zend_Log_Filter_Priority':
							$priorities = array_flip( $log->getPriorities() );
							$priority = strtoupper( $filter['priority']['threshold'] );
							$filter = new Zend_Log_Filter_Priority( $priorities[ $priority ] );
							break;
						
						case 'Zend_Log_Filter_Message':
							$regex = $filter['message']['regex'];
							$filter = new Zend_Log_Filter_Message( $regex );
							break;
						
						default:
							if ( class_exists( $class ) )
							{
								$filter = new $class;
								break;
							}
							
							throw new Dk_Log_Exception( 
								"Unknown filter: $filter",
								Dk_Log_Exception::UNKNOWN_FILTER
							);
							break;
					}
					
					$writer->addFilter( $filter );
				}
			}
			
			// Set writer formatter
			if ( $formatter )
			{
				$class = $formatter['class'];
				
				switch ( $class )
				{
					case 'Zend_Log_Formatter_Simple':
						$format = ( isset( $formatter['format'] ) ? $formatter['format'] : null );
						$formatter = new Zend_Log_Formatter_Simple( $format . "\n" );
						break;
					
					case 'Zend_Log_Formatter_Xml':
						$rootNode = ( isset( $formatter['rootNode'] ) ? $formatter['rootNode'] : 'logEntry' );
						$nodeMap = null;
						
						if ( $formatter['map'] )
						{
							$nodeMap = array();
							
							foreach ( $formatter['map'] as $map )
							{
								$nodeMap[ $map['node'] ] = $map['property'];
							}
						}
						
						$formatter = new Zend_Log_Formatter_Xml( $rootNode, $nodeMap );
						break;

					default:
						if ( class_exists( $class ) )
						{
							$formatter = new $class;
							break;
						}

						throw new Dk_Log_Exception( 
							"Unknown formatter: $class",
							Dk_Log_Exception::UNKNOWN_FORMATTER
						);
						break;
				}
				
				$writer->setFormatter( $formatter );
			}
			
			$log->addWriter( $writer );
			
		}
		
		return $log;
	}
}
