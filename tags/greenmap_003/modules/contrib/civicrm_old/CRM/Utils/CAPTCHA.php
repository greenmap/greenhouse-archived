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
 | at http://www.openngo.org/faqs/licensing.html                      |
 +--------------------------------------------------------------------+
*/

/**
 * Class to handle capthca related image and verification
 *
 * @package CRM
 * @author Donald A. Lobo <lobo@yahoo.com>
 * @copyright Donald A. Lobo (c) 2005
 * $Id$
 *
 */

$GLOBALS['_CRM_UTILS_CAPTCHA']['_singleton'] =  null;

class CRM_Utils_CAPTCHA {

    var $_captcha = null;

    var $_name    = null;

    var $_url     = null;

    var $_phrase  = null;

    /**
     * We only need one instance of this object. So we use the singleton
     * pattern and cache the instance in this variable
     *
     * @var object
     * @static
     */
    

    /**
     * singleton function used to manage this object
     *
     * @param string the key to permit session scope's
     *
     * @return object
     * @static
     *
     */
     function &singleton( ) {
        if ($GLOBALS['_CRM_UTILS_CAPTCHA']['_singleton'] === null ) {
            $GLOBALS['_CRM_UTILS_CAPTCHA']['_singleton'] =& new CRM_Utils_CAPTCHA( );
        }
        return $GLOBALS['_CRM_UTILS_CAPTCHA']['_singleton'];
    }

    function CRM_Utils_CAPTCHA( ) {
    }

    /**
     * class constructor
     *
     */
    function init( $phrase, $size, $path, $file, $width, $height ) {
        $options = array( 'font_size' => $size,
                          'font_path' => $path,
                          'font_file' => $file );
        require_once 'Text/CAPTCHA.php';
        $this->_captcha =& Text_CAPTCHA::factory( 'Image' );
        $retval = $this->_captcha->init( $width, $height, $phrase, $options );
        if ( PEAR::isError( $retval ) ) {
            CRM_Core_Error::statusBounce( ts( 'Error initializing CAPTCHA library' ) );
        }

        $config =& CRM_Core_Config::singleton( );
        $this->_name = $config->imageUploadDir . 'captcha_' . md5( session_id( ) ) . '.png';
        $this->_url  = $config->imageUploadURL . 'captcha_' . md5( session_id( ) ) . '.png';
    }


    /**
     * Add element to form
     *
     */
    function add( &$form,
                  $size   = 24,
                  $path   = '/usr/X11R6/lib/X11/fonts/webfonts/',
                  $file   = 'cour.ttf',
                  $width  = 200,
                  $height = 80 ) {

        $phrase = $form->get( 'captcha_phrase' );
        $this->init( $phrase, $size, $path, $file, $width, $height );

        // get CAPTCHA image
        $png = $this->_captcha->getCAPTCHAAsPNG( );
        if ( PEAR::isError( $png ) ) {
            CRM_Core_Error::statusBounce( ts( 'Error generating CAPTCHA image' ) );
        }
        
        // store the file keyed to the session for now
        CRM_Utils_File::put( $this->_name, $png );
                             
        $form->set( 'captcha_phrase', $this->_captcha->getPhrase( ) );
        $form->add( 'text',
                    'captcha_phrase',
                    ts( 'Please enter the phrase as displayed in the image.' ),
                    null,
                    true );
        $form->registerRule( 'captcha', 'callback', 'validate', 'CRM_Utils_CAPTCHA' );
        $form->addRule( 'captcha_phrase', ts( 'Input text must match the phrase in the image. Please review the image and re-enter matching text.' ), 'captcha', $form );
        $form->addElement( 'image','captcha_image',  $this->_url );
    }

    function validate( $value, &$form ) {
        return ( $value == $form->get( 'captcha_phrase' ) ) ? true : false;
    }

}

?>
