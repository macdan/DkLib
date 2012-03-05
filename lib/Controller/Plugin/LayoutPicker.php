<?php

/**
 * LayoutPicker.php
 *
 * @author Daniel Kendell <daniel.kendell@gmail.com>
 */

/**
 * Dk_Controller_Plugin_LayoutPicker
 *
 * @package Dk
 * @subpackage ControllerPlugins
 * @uses Zend_Controller_Plugin_Abstract
 */
class Dk_Controller_Plugin_LayoutPicker extends Zend_Controller_Plugin_Abstract
{
	/**
	 * preDispatch
	 *
	 * Sets the layout template to match the module name.
	 *
	 * @access public
	 * @param Zend_Controller_Request_Abstract $request The request object
	 * @return null
	 */
	public function preDispatch( Zend_Controller_Request_Abstract $request )
	{
            $module = $request->getModuleName();
            $module = ( $module ? $module : 'default' );

            $bootstrap = Zend_Controller_Front::getInstance()
                    ->getParam( 'bootstrap' );

            if ( $bootstrap->hasResource( 'log' ) )
            {
                    $bootstrap->getResource( 'log' )
                            ->debug( __METHOD__ . " - Setting layout to {$module}" );
            }

            Zend_Layout::getMvcInstance()->setLayout( $module );
	}
}
