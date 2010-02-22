<?php
/*
 +--------------------------------------------------------------------+
 | CiviCRM version 1.5                                                |
 +--------------------------------------------------------------------+
 | Copyright (c) 2005 Donald A. Lobo                                  |
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
 * Component stores all the static and dynamic information of the various
 * CiviCRM components
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_CORE_COMPONENT']['_info'] =  null;
$GLOBALS['_CRM_CORE_COMPONENT']['_contactSubTypes'] =  null;

class CRM_Core_Component {
    

    

     function &info( ) {
        if ( $GLOBALS['_CRM_CORE_COMPONENT']['_info'] == null ) { 
            $GLOBALS['_CRM_CORE_COMPONENT']['_info'] = array( );

            $GLOBALS['_CRM_CORE_COMPONENT']['_info']['CiviContribute'] = 
                array( 'title'   => 'CiviCRM Contribution Engine',
                       'path'    => 'CRM_Contribute_',
                       'url'     => 'contribute',
                       'perm'    => array( 'access CiviContribute',
                                           'edit contributions',
                                           'make online contributions' ),
                       'search'  => 1 );

            $GLOBALS['_CRM_CORE_COMPONENT']['_info']['CiviMember'] = 
                array( 'title'   => 'CiviCRM Membership Engine',
                       'path'    => 'CRM_Member_',
                       'url'     => 'member',
                       'perm'    => array( 'access CiviMember',
                                           'edit members'),
                       'search'  => 1 );

            $GLOBALS['_CRM_CORE_COMPONENT']['_info']['CiviMail'] = 
                array( 'title'   => 'CiviCRM Mailing Engine',
                       'path'    => 'CRM_Mailing_',
                       'url'     => 'mailing',
                       'perm'    => array( 'access CiviMail' ),
                       'search'  => 0 );

            $GLOBALS['_CRM_CORE_COMPONENT']['_info']['Quest'] =
                array( 'title'   => 'Quest Application Process',
                       'path'    => 'CRM_Quest_',
                       'url'     => 'quest',
                       'perm'    => array( 'edit Quest Application',
                                           'view Quest Application',
                                           'edit Quest Recommendation',
                                           'view Quest Recommendation'),
                       'search'  => 1,
                       'metaTpl' => 'quest',
                       'formTpl' => 'quest',
                       'task'    => array( '32' => array( 'title'  => 'Export XML',
                                                          'class'  => 'CRM_Quest_Form_Task_XML',
                                                          'result' => false ),
                                           '33' => array( 'title'  => 'Export PDF',
                                                          'class'  => 'CRM_Quest_Form_Task_PDF',
                                                          'result' => false ) ) );
        }
        return $GLOBALS['_CRM_CORE_COMPONENT']['_info'];
    }

     function get( $name, $attribute = null) {
        $info =& CRM_Core_Component::info( );

        $comp = CRM_Utils_Array::value( $name, $info );
        if ( $attribute ) {
            return CRM_Utils_Array::value( $attribute, $comp );
        }
        return $comp;
    }

     function invoke( &$args, $type ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 ( $info[$name]['url'] === $args[1] || $info[$name]['url'] === $args[2] ) ) {
                
                $className = $info[$name]['path'] . 'Invoke';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                
                if ( $type == 'main' ) {
                    // also set the smarty variables to the current component
                    $template =& CRM_Core_Smarty::singleton( );
                    $template->assign( 'activeComponent', $name );
                    if ( CRM_Utils_Array::value( 'metaTpl', $info[$name] ) ) {
                        $template->assign( 'metaTpl', $info[$name]['metaTpl'] );
                    }
                    if ( CRM_Utils_Array::value( 'formTpl', $info[$name] ) ) {
                        $template->assign( 'formTpl', $info[$name]['formTpl'] );
                    }
                    if ( CRM_Utils_Array::value( 'css', $info[$name] ) ) {
                        $styleSheets = '<style type="text/css">@import url(' . "{$config->resourceBase}css/{$info[$name]['css']});</style>";

                        CRM_Utils_System::addHTMLHead( $styleSheet );
                    }
                }
                eval( $className . '::' . $type . '( $args );' );
                return true;
            }
        }
        return false;
    }

     function &menu( ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        $items = array( );
        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) ) {
                $className = $info[$name]['path'] . 'Menu';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( '$ret = ' . $className . '::main( );' );
                $items = array_merge( $items, $ret );
            }
        }
        return $items;
    }

     function addConfig( &$config ) {
        $info =& CRM_Core_Component::info( );

        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) ) {
                $className = $info[$name]['path'] . 'Config';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( $className . '::add( $config );' );
            }
        }
        return;
    }

     function &getQueryFields( ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );
        $fields = array( );
        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( '$flds =& ' . $className . '::getFields( );' );
                $fields = array_merge( $fields, $flds );
            }
        }
        return $fields;
    }

     function &alterQuery( &$query, $fnName ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( $className . '::' . $fnName . '( $query );' );
            }
        }
    }

     function from( $fieldName, $mode, $side ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        $from = null;
        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( '$from = ' . $className . '::from( $fieldName, $mode, $side );' );
                if ( $from ) {
                    return $from;
                }
            }
        }
        return $from;
    }

     function &defaultReturnProperties( $mode ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );
        $properties = null;
        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( '$properties =& ' . $className . '::defaultReturnProperties( $mode );' );
                if ( $properties ) {
                    return $properties;
                }
            }
        }
        return $properties;
    }

     function &buildSearchForm( &$form ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( $className . '::buildSearchForm( $form );' );
            }
        }
    }

     function &addShowHide( &$showHide ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( $className . '::addShowHide( $showHide );' );
            }
        }
    }

     function &searchAction( &$row, $id ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) &&
                 $value['search'] ) {
                $className = $info[$name]['path'] . 'BAO_Query';
                require_once(str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php');
                eval( $className . '::searchAction( $row, $id );' );
            }
        }
    }

     function &contactSubTypes( ) {
        if ( $GLOBALS['_CRM_CORE_COMPONENT']['_contactSubTypes'] == null ) {
            $GLOBALS['_CRM_CORE_COMPONENT']['_contactSubTypes'] =
                array(
                      'Student' =>
                      array( 'View' => 
                             array( 'file'  => 'CRM/Quest/Page/View/Student.php',
                                    'class' => 'CRM_Quest_Page_View_Student' ),
                             )
                      );
        }
        return $GLOBALS['_CRM_CORE_COMPONENT']['_contactSubTypes'];
    }

    
     function &contactSubTypeProperties( $subType, $op ) {
        $properties =& CRM_Core_Component::contactSubTypes( );
        if ( array_key_exists( $subType, $properties ) &&
             array_key_exists( $op, $properties[$subType] ) ) {
            return $properties[$subType][$op];
        }
    }

     function &taskList( ) {
        $info =& CRM_Core_Component::info( );
        $config =& CRM_Core_Config::singleton( );

        $tasks = array( );
        foreach ( $info as $name => $value ) {
            if ( in_array( $name, $config->enableComponents ) && 
                 CRM_Utils_Array::value( 'task', $info[$name] ) ) {
                $tasks += $info[$name]['task'];
            }
        }
        return $tasks;
    }

}

?>