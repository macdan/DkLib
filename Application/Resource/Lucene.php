<?php

/**
 * Lucene.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Application_Resource_Lucene
 * 
 * @package Dk
 * @subpackage ApplicationResources
 * @uses Zend_Application_Resource_ResourceAbstract
 */
class Dk_Application_Resource_Lucene extends Zend_Application_Resource_ResourceAbstract
{
	/**
	 * @access protected
	 * @var string The base path of the Lucene indexes
	 */
	protected $_indexBasePath = '';

	/**
	 * @access protected
	 * @var array The Lucene indexes
	 */
	protected $_indexes = array();

	/**
	 * Init
	 *
	 * Get the index path from application config and load the lucene index if
	 * it's present.
	 *
	 * @access public
	 * @return (bool|Zend_Search_Lucene_Interface) The index object or bool(false)
	 */
	public function init()
	{
		$options = $this->getOptions();

		if ( !isset( $options['indexPath'] ) )
		{
			throw new Dk_Application_Resource_Lucene_Exception(
				'No lucene index path has been specified',
				Dk_Application_Resource_Lucene_Exception::NO_INDEX_PATH
			);
		}

		$this->_indexBasePath = $options['indexPath'];

		return $this;
	}

	/**
	 * Get Index
	 *
	 * Returns an index object, if it isn't open, it tries to open it, if it
	 * can't open the index, then it'll attempt to create the index
	 *
	 * @access public
	 * @param string $name The name of the index
	 * @return Zend_Search_Lucene_Interface The Lucene index
	 */
	public function getIndex( $name )
	{
		if ( !isset( $this->_indexes[ $name ] ) )
		{
			try
			{
				$index = $this->openIndex( $name );
			}
			catch ( Exception $e )
			{
				$index = $this->createIndex( $name );
			}

			$this->_indexes[ $name ] = $index;
		}

		return $this->_indexes[ $name ];
	}

	/**
	 * Create Index
	 *
	 * Creates a new index with the name specified
	 *
	 * @access public
	 * @param string $name The name of the new index
	 * @return Zend_Search_Lucene_Interface The Lucene index object
	 */
	public function createIndex( $name )
	{
		return Zend_Search_Lucene::create( $this->_indexBasePath . '/' . $name );
	}

	/**
	 * Open Index
	 *
	 * Opens an already existing index by name
	 *
	 * @access public
	 * @param string $name The name of the index
	 * @return Zend_Search_Lucene_Interface The Lucene index object
	 */
	public function openIndex( $name )
	{
		return Zend_Search_Lucene::open( $this->_indexBasePath . '/' . $name );
	}
}
