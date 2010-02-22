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

$GLOBALS['_CRM_UTILS_REQUEST']['_singleton'] =  null;

require_once 'CRM/Core/Action.php';

/**
 * class for managing a http request
 *
 */
class CRM_Utils_Request {
    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     *
     * @var object
     * @access private
     * @static
     */
    

    /**
     * class constructor
     */
    function CRM_Utils_Request() {
    }

    /**
     * get the variable information from the request (GET/POST/SESSION
     *
     * @param $name    name of the variable to be retrieved
     * @param $type    type of the variable (see CRM_Utils_Type for details)
     * @param $store   session scope where variable is stored
     * @param $abort   is this variable required
     * @param $default default value of the variable if not present
     * @param $method  where should we look for the variable
     *
     * @return string  the value of the variable
     * @access public
     * @static
     *
     */
     function retrieve( $name, $type, &$store, $abort = false, $default = null, $method = 'GET' ) {

        // hack to detect stuff not yet converted to new style
        if ( ! is_string( $type ) ) {
            CRM_Core_Error::backtrace( );
            CRM_Utils_Error::fatal( "Please convert retrieve call to use new function signature" );
        }

        $value = null;
        switch ( $method ) {
        case 'GET':
            $value = CRM_Utils_Array::value( $name, $_GET );
            break;

        case 'POST':
            $value = CRM_Utils_Array::value( $name, $_POST );
            break;
            
        default:
            $value = CRM_Utils_Array::value( $name, $_REQUEST );
            break;
        }

        if ( isset( $value ) &&
             ( CRM_Utils_Type::validate( $value, $type, $abort ) === null ) ) {
            $value = null;
            unset( $value );
        }
        
        if ( ! isset( $value ) && $store ) {
            $value = $store->get( $name );
        }

        if ( ! isset( $value ) && $abort ) {
            CRM_Core_Error::fatal( "Could not find valid value for $name" );
        }

        if ( ! isset( $value ) && $default ) {
            $value = $default;
        }
        
        // minor hack for action
        if ( $name == 'action' && is_string( $value ) ) {
            $value = CRM_Core_Action::resolve( $value );
        }

        if ( isset( $value ) && $store ) {
            $store->set( $name, $value );
        }

        return $value;
    }

}

?>