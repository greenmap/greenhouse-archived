<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 1.5                                                |
 +--------------------------------------------------------------------+
 | Copyright CiviCRM LLC (c) 2004-2006                                  |
 +--------------------------------------------------------------------+
 | This file is a part of CiviCRM.                                    |
 |                                                                    |
 | CiviCRM is free software; you can copy, modify, and distribute it  |
 | under the terms of the Affero General Public License Version 1,    |
 | March 2002.                                                        |
 |                                                                    |
 | CiviCRM is distributed in the hope that it will be useful, but     |
 | WITHOUT ANY WARRANTY; without even the implied warranty of         |
 | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
 | See the Affero General Public License for more details.            |
 |                                                                    |
 | You should have received a copy of the Affero General Public       |
 | License along with this program; if not, contact the Social Source |
 | Foundation at info[AT]socialsourcefoundation[DOT]org.  If you have |
 | questions about the Affero General Public License or the licensing |
 | of CiviCRM, see the Social Source Foundation CiviCRM license FAQ   |
 | at http://www.openngo.org/faqs/licensing.html                       |
 +--------------------------------------------------------------------+
*/

/**
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright CiviCRM LLC (c) 2004-2006
 * $Id$
 *
 */


require_once 'CRM/Core/Controller.php';

class CRM_Mailing_Controller_Send extends CRM_Core_Controller {

    /**
     * class constructor
     */
    function CRM_Mailing_Controller_Send( $title = null, $action = CRM_CORE_ACTION_NONE, $modal = true ) {
        require_once 'CRM/Mailing/StateMachine/Send.php';
        parent::CRM_Core_Controller( $title, $modal );

        $this->_stateMachine =& new CRM_Mailing_StateMachine_Send( $this, $action );

        // create and instantiate the pages
        $this->addPages( $this->_stateMachine, $action );

        // add all the actions
        $config =& CRM_Core_Config::singleton( );
        $this->addActions( $config->uploadDir, array( 'textFile', 'htmlFile' ) );
    }

}

?>