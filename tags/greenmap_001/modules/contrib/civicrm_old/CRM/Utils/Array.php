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
 * Simple wrapper class to add a few essential core functions to
 * arrays in PHP
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_UTILS_ARRAY']['src'] =  null;
$GLOBALS['_CRM_UTILS_ARRAY']['dst'] =  null;

class CRM_Utils_Array {

    /**
     * if the key exists in the list returns the associated value
     *
     * @access public
     *
     * @param array  $list  the array to be searched
     * @param string $key   the key value
     * 
     * @return value if exists else null
     * @static
     * @access public
     *
     */
     function value( $key, &$list, $default = null ) {
        if ( is_array( $list ) ) {
            return array_key_exists( $key, $list ) ? $list[$key] : $default;
        }
        return $default;
    }

    /**
     * if the value exists in the list returns the associated key
     *
     * @access public
     *
     * @param list  the array to be searched
     * @param value the search value
     * 
     * @return key if exists else null
     * @static
     * @access public
     *
     */
     function key( $value, &$list ) {
        if ( is_array( $list ) ) {
            $key = array_search( $value, $list );
            return $key ? $key : null;
        }
        return null;
    }

     function &xml( &$list, $depth = 1, $seperator = "\n" ) {
        $xml = '';
        foreach( $list as $name => $value ) {
            $xml .= str_repeat( ' ', $depth * 4 );
            if ( is_array( $value ) ) {
                $xml .= "<{$name}>{$seperator}";
                $xml .= CRM_Utils_Array::xml( $value, $depth + 1, $seperator );
                $xml .= str_repeat( ' ', $depth * 4 );
                $xml .= "</{$name}>{$seperator}";
            } else {
                // make sure we escape value
                $value = CRM_Utils_Array::escapeXML( $value );
                $xml .= "<{$name}>$value</{$name}>{$seperator}";
            }
        }
        return $xml;
    }

     function escapeXML( $value ) {
        
        

        if ( ! $GLOBALS['_CRM_UTILS_ARRAY']['src'] ) {
            $GLOBALS['_CRM_UTILS_ARRAY']['src'] = array( '&'    , '<'   , '>'    );
            $GLOBALS['_CRM_UTILS_ARRAY']['dst'] = array( '&amp;', '&lt;', '&gt;' );
        }

        return str_replace( $GLOBALS['_CRM_UTILS_ARRAY']['src'], $GLOBALS['_CRM_UTILS_ARRAY']['dst'], $value );
    }


     function &flatten( &$list, &$flat, $prefix = '', $seperator = "." ) {
        foreach( $list as $name => $value ) {
            $newPrefix = ( $prefix ) ? $prefix . $seperator . $name : $name;
            if ( is_array( $value ) ) {
                CRM_Utils_Array::flatten( $value, $flat, $newPrefix, $seperator );
            } else {
                if ( ! empty( $value ) ) {
                    $flat[$newPrefix] = $value;
                }
            }
        }
    }

    /**
     * Funtion to merge to two arrays recursively
     * 
     * @param array $a1 
     * @param array $a2
     *
     * @return  $a3
     * @static
     */
     function crmArrayMerge( $a1, $a2 ) 
    {
        if ( empty($a1) ) {
            return $a2;
        }

        if ( empty( $a2 ) ) {
            return $a1;
        }

        $a3 = array( );
        foreach ( $a1 as $key => $value) {
            if ( array_key_exists($key, $a2) ) {
                $a3[$key] = array_merge($a1[$key], $a2[$key]);
            } else {
                $a3[$key] = $a1[$key];
            }
        }

        return $a3;
    }
}

?>