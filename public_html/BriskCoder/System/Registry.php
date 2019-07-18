<?php

/**
 * BriskCoder
 * NOTICE OF LICENSE
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code. 
 * This software is furnished under a license and may be used and copied
 * only  in  accordance  with  the  terms  of such  license and with the
 * inclusion of the above copyright notice.  This software  or any other
 * copies thereof may not be provided or otherwise made available to any
 * other person.  No title to and  ownership of the  software is  hereby
 * transferred.
 * You may not reverse  engineer, decompile, defeat  license  encryption
 * mechanisms, or  disassemble this software product or software product
 * license.  BoxBilling may terminate this license if you don't
 * comply with any of the terms and conditions set forth in our end user
 * license agreement (EULA).  In such event,  licensee  agrees to return
 * licensor  or destroy  all copies of software  upon termination of the
 * license.
 * This file is part BriskCoder
 * @copyright   Copyright (c) 2010 Xpler Corporation. (http://www.xpler.com)
 * @license     Please see the EULA file for the full End User License Agreement. http://www.`briskcoder.com/license/ 
 * @author      www.xpler.com <sales@xpler.com>
 * @version     1.0.0
 */

namespace BriskCoder\System;

class Registry
{

    public
            $DISPATCHER_ALIAS,
            $DISPATCHER_NS,
            $DISPATCHER_URI,
            $DOMAIN_FQDN,
            $DOMAIN_ID = 1,
            $_DOMAINS = array(),
            $LANGUAGE_ID = 1,
            $CLIENT_IP,
            $SERVER_IP,
            $PROTOCOL,
            $DYNAMIC_SEGMENT_KEY,
            $PROJECT_ALIAS,
            $PROJECT_PACKAGE,
            $URI,
            $URI_NO_QS,
            $URI_REFERER,
            $URI_SEGMENT,
            $USER_AGENT,
            $DEFAULT_PROJECT_ALIAS,
            $DEFAULT_PROJECT_PACKAGE,
            $DEFAULT_PROJECT_PACKAGE_UUID = 1,
            $EXTERNAL_TEMPLATE,
            $HAS_DYNAMIC_SEGMENT = FALSE,
            $IS_DYNAMIC_SEGMENT_SUBDOMAIN = FALSE,
            $IS_REMOTE_MEDIA_TIER = FALSE,
            $MEDIA_PATH_SYSTEM,
            $MEDIA_PATH_URI,
            $_LANGUAGES = array( 1 => array(
                    'languages_tag' => 'en-us',
                    'languages_name' => 'US English',
                    'languages_name_en' => 'US English',
                    'languages_status' => 1,
                    'languages_created' => '',
                    'languages_modified' => '',
                ) ),
            $_DISPATCHER_ALIAS = array(),
            $_DYNAMIC_ROUTE = array(),
            $_DYNAMIC_SEGMENT,
            $_PROJECTS,
            $_REMOTE_MEDIA_TIERS = array();
    private $_magic = array();

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\bc' )
            exit( 'Forbidden System class: Registry' );
    }

    public function __set( $name, $value )
    {
        $this->_magic[$name] = $value;
    }

    public function &__get( $name )
    {
        return $this->_magic[$name];
    }

    public function __isset( $name )
    {
        return isset( $this->_magic[$name] );
    }

    public function __unset( $name )
    {
        unset( $this->_magic[$name] );
    }

}
