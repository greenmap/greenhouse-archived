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

define( 'CRM_UTILS_TYPE_T_INT',1);
define( 'CRM_UTILS_TYPE_T_STRING',2);
define( 'CRM_UTILS_TYPE_T_ENUM',2);
define( 'CRM_UTILS_TYPE_T_DATE',4);
define( 'CRM_UTILS_TYPE_T_TIME',8);
define( 'CRM_UTILS_TYPE_T_BOOL',16);
define( 'CRM_UTILS_TYPE_T_BOOLEAN',16);
define( 'CRM_UTILS_TYPE_T_TEXT',32);
define( 'CRM_UTILS_TYPE_T_BLOB',64);
define( 'CRM_UTILS_TYPE_T_TIMESTAMP',256);
define( 'CRM_UTILS_TYPE_T_FLOAT',512);
define( 'CRM_UTILS_TYPE_T_MONEY',1024);
define( 'CRM_UTILS_TYPE_T_EMAIL',2048);
define( 'CRM_UTILS_TYPE_T_URL',4096);
define( 'CRM_UTILS_TYPE_T_CCNUM',8192);
define( 'CRM_UTILS_TYPE_T_MEDIUMBLOB',16384);
define( 'CRM_UTILS_TYPE_TWO',2);
define( 'CRM_UTILS_TYPE_FOUR',4);
define( 'CRM_UTILS_TYPE_EIGHT',8);
define( 'CRM_UTILS_TYPE_TWELVE',12);
define( 'CRM_UTILS_TYPE_SIXTEEN',16);
define( 'CRM_UTILS_TYPE_TWENTY',20);
define( 'CRM_UTILS_TYPE_MEDIUM',20);
define( 'CRM_UTILS_TYPE_THIRTY',30);
define( 'CRM_UTILS_TYPE_BIG',30);
define( 'CRM_UTILS_TYPE_FORTYFIVE',45);
define( 'CRM_UTILS_TYPE_HUGE',45);

class CRM_Utils_Type {
    
                    
                 
                   
                   
                   
                  
               
                  
                  
            
                
               
               
                 
               
               

    
                    
                   
                  
                
               
                
                
                
                   
             
                  

   

    /**
     * Convert Constant Data type to String
     *
     * @param  $type       integer datatype
     * 
     * @return $string     String datatype respective to integer datatype
     *
     * @access public
     */


    function typeToString( $type ) {
        switch ( $type ) {
        case 1   : $string = 'Int'      ; break;
        case 2   : $string = 'String'   ; break;
        case 3   : $string = 'Enum'     ; break;
        case 4   : $string = 'Date'     ; break; 
        case 8   : $string = 'Time'     ; break;
        case 16  : $string = 'Boolean'  ; break;    
        case 32  : $string = 'Text'     ; break;
        case 64  : $string = 'Blob'     ; break;    
        case 256 : $string = 'Timestamp'; break;
        case 512 : $string = 'Float'    ; break;
        case 1024: $string = 'Money'    ; break;
        case 2048: $string = 'Date'     ; break;
        case 4096: $string = 'Email'    ; break;
        case 16384: $string = 'Mediumblob'    ; break;    
        }
        
        return $string;

    }


    /**
     * Verify that a variable is of a given type
     * 
     * @param mixed   $data         The variable
     * @param string  $type         The type
     * @param boolean $abort        Should we abort if invalid
     * @return mixed                The data, escaped if necessary
     * @access public
     * @static
     */
      function escape($data, $type, $abort = true) {
        require_once 'CRM/Utils/Rule.php';
        switch($type) {
        case 'Integer':
        case 'Int':
            if (CRM_Utils_Rule::integer($data)) {
                return $data;
            }
            break;

        case 'Positive':
            if (CRM_Utils_Rule::positiveInteger($data)) {
                return $data;
            }
            break;

        case 'Boolean':
            if (CRM_Utils_Rule::boolean($data)) {
                return $data;
            }
            break;

        case 'Float':
        case 'Money':
            if (CRM_Utils_Rule::numeric($data)) {
                return $data;
            }
            break;
            
        case 'String':
            return addslashes($data);
            break;
            
        case 'Date':
            if (preg_match('/^\d{8}$/', $data)) {
                return $data;
            }
            break;
            
        case 'Timestamp':
            if (preg_match('/^\d{14}$/', $data)) {
                return $data;
            }
            break;
            
        default:
            CRM_Core_Error::fatal( "Cannot recognize $type for $data" );
            break;
        }

        if ( $abort ) {
            CRM_Core_Error::fatal( "$data is not of the type $type" );
        }
        return null;
    }

    /**
     * Verify that a variable is of a given type
     * 
     * @param mixed   $data         The variable
     * @param string  $type         The type
     * @param boolean $abort        Should we abort if invalid
     * @return mixed                The data, escaped if necessary
     * @access public
     * @static
     */
      function validate($data, $type, $abort = true) {
        require_once 'CRM/Utils/Rule.php';
        switch($type) {
        case 'Integer':
            if (CRM_Utils_Rule::integer($data)) {
                return $data;
            }
            break;

        case 'Positive':
            if (CRM_Utils_Rule::positiveInteger($data)) {
                return $data;
            }
            break;

        case 'Boolean':
            if (CRM_Utils_Rule::boolean($data)) {
                return $data;
            }
            break;

        case 'Float':
        case 'Money':
            if (CRM_Utils_Rule::numeric($data)) {
                return $data;
            }
            break;
            
        case 'String':
            return $data;
            break;
            
        case 'Date':
            if (preg_match('/^\d{8}$/', $data)) {
                return $data;
            }
            break;
            
        case 'Timestamp':
            if (preg_match('/^\d{14}$/', $data)) {
                return $data;
            }
            break;
            
        default:
            CRM_Core_Error::fatal( "Cannot recognize $type for $data" );
            break;
        }

        if ( $abort ) {
            CRM_Core_Error::fatal( "$data is not of the type $type" );
        }

        return null;
    }
}

?>