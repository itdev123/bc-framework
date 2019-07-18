<?php

namespace BriskCoder\Package\Module\bcUAC\Libs;

use BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\Config,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel;

final class RBAC
{

    private
            $_ns = array(),
            $currNS = NULL;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * ADD AUTH ROLE
     * Add bcUAC::rbac()->model()->uac_auth_roles()
     * @param Integer $AUTH_ID NN UN BIGINT(20)
     * @param Integer $ROLE_ID NN UN BIGINT(20)     
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addAuthRole( $AUTH_ID, $ROLE_ID, $RETURN_ID = FALSE )
    {
        $authRolesCol = $this->configModel()->uac_auth_roles(); //assign RBAC Auth Roles Model Columns
        $_columns = array();
        $_columns[$authRolesCol->auth_id] = array( $AUTH_ID, bcDB::TYPE_INTEGER );
        $_columns[$authRolesCol->role_id] = array( $ROLE_ID, bcDB::TYPE_INTEGER );
        return $this->model()->uac_auth_roles()->write( $_columns, $RETURN_ID );
    }

    /**
     * DELETE AUTH ROLES BY AUTH ID
     * Delete  bcUAC::rbac()->model()->uac_auth_roles() by $AUTH_ID
     * @param Integer $AUTH_ID NN UN BIGINT(20)
     * @return Boolean
     * @author Emily
     */
    public function deleteAuthRolesByAuthID( $AUTH_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_auth_roles()->auth_id] = array( '=', $AUTH_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth_roles()->delete( $_filters, array(), NULL );
    }

    /**
     * GET AUTH ROLE IDS BY AUTH ID
     * @param Integer $AUTH_ID NN UN BIGINT(20)
     * @return Array
     * @author Emily
     */
    public function getAuthRoleIDsByAuthID( $AUTH_ID )
    {
        $authRolesCol = $this->configModel()->uac_auth_roles(); //assign RBAC Auth Roles Model Columns
        $_columns = array();
        $_columns[] = $authRolesCol->role_id;
        $_filters = array();
        $_filters[$authRolesCol->auth_id] = array( '=', $AUTH_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_auth_roles()->read( TRUE, $_columns, $_filters, array(), NULL );
    }

    /**
     * GET AUTH ROLES
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getAuthRoles( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_auth_roles()->read( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * ADD ROLE
     * Add bcUAC::rbac()->model()->uac_roles()
     * @param Integer $STATUS NN TINYINT(1) DEFAULT '0'   
     * @param Integer $PRIORITY NN INT(11)    
     * @param Integer $GROUP_ID NN TINYINT(3)    
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addRole( $STATUS, $PRIORITY, $GROUP_ID, $RETURN_ID = FALSE )
    {
        $rolesCol = $this->configModel()->uac_roles(); //assign RBAC Roles Model Columns
        $_columns = array();
        if ( !empty( $id ) ):
            $_columns[$rolesCol->id] = array( $id, bcDB::TYPE_INTEGER );
        endif;
        $_columns[$rolesCol->status] = array( $STATUS, bcDB::TYPE_INTEGER );
        $_columns[$rolesCol->priority] = array( $PRIORITY, bcDB::TYPE_INTEGER );
        $_columns[$rolesCol->group_id] = array( $GROUP_ID, bcDB::TYPE_INTEGER );
        return $this->model()->uac_roles()->write( $_columns, $RETURN_ID );
    }

    /**
     * UPDATE ROLE
     * Update bcUAC::rbac()->model()->uac_roles() columns value by id
     * @param Integer $ID PK NN UN AI BIGINT(20) 
     * @param Integer $STATUS NN TINYINT(1) DEFAULT '0'
     * @param Integer $PRIORITY NN INT(11)
     * @param Integer $GROUP_ID NN TINYINT(3)    
     * @return Boolean
     * @author Emily
     */
    public function updateRole( $ID, $STATUS, $PRIORITY, $GROUP_ID )
    {
        $rolesCol = $this->configModel()->uac_roles(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[$rolesCol->status] = array( $STATUS, bcDB::TYPE_INTEGER );
        $_columns[$rolesCol->priority] = array( $PRIORITY, bcDB::TYPE_INTEGER );
        $_columns[$rolesCol->group_id] = array( $GROUP_ID, bcDB::TYPE_INTEGER );
        $_filters = array();
        $_filters[$rolesCol->id] = array( '=', $ID, FALSE, NULL );
        return $this->model()->uac_roles()->update( $_columns, $_filters, array(), NULL );
    }

    /**
     * DELETE ROLE
     * Delete  bcUAC::rbac()->model()->uac_roles() by $ID
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Boolean
     * @author Emily
     */
    public function deleteRole( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles()->delete( $_filters, array(), NULL );
    }

    /**
     * GET ROLE STATUS
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Integer
     */
    public function getRoleStatus( $ID )
    {
        $rolesCol = $this->configModel()->uac_roles(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[] = $rolesCol->status;
        $_filters = array();
        $_filters[$rolesCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_roles()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$rolesCol->status];
    }

    /**
     * GET ROLE PRIORITY     
     * @return Integer
     */
    public function getRolesMaxPriority()
    {
        $rolesCol = $this->configModel()->uac_roles(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[] = 'MAX(' . $rolesCol->priority . ') as priority';
        $_data = $this->model()->uac_roles()->read( FALSE, $_columns, array(), array(), NULL );
        return $_data['priority'];
    }

    /**
     * GET ROLE and ROLE TEXT BY ID and LANGUAGE ID
     * Get all bcUAC::rbac()->model()->uac_roles() and bcUAC::rbac()->model()->uac_roles_text() columns by id and language_id
     * @param Integer $ID PK NN UN AI BIGINT(20) 
     * @param Integer $LANGUAGE_ID NN UN INT(10)  
     * @return Array
     * @author Emily
     */
    public function getRoleByLanguageID( $ID, $LANGUAGE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, 'AND' );
        $_filters[$this->configModel()->uac_roles_text()->language_id] = array( '=', $LANGUAGE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles()->uac_roles_text()->read_left_join( FALSE, array(), $_filters, array(), NULL );
    }

    /**
     * GET ROLE
     * Get all bcUAC::rbac()->model()->uac_roles() columns by id
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return Array
     * @author Emily
     */
    public function getRole( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles()->read( FALSE, array(), $_filters, array(), NULL );
    }

    /**
     * GET ROLES, ROLES TEXT, ROLSE GROUPS, AND ROLES GROUPS TEXT
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getRoles( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_roles()->uac_roles_text()->uac_roles_groups()->uac_roles_groups_text()->read_left_join( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * GET ROLES and ROLES TEXT BY  LANGUAGE ID
     * Get all bcUAC::rbac()->model()->uac_roles() and bcUAC::rbac()->model()->uac_roles_text() columns  language_id     
     * @param Integer $LANGUAGE_ID NN UN INT(10)  
     * @return Array
     * @author Emily
     */
    public function getRolesByLanguageID( $LANGUAGE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_text()->language_id] = array( '=', $LANGUAGE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles()->uac_roles_text()->read_left_join( TRUE, array(), $_filters, array(), NULL );
    }

    /**
     * GET TOTAL ROLES and ROLES TEXT RECORDS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @return Integer
     * @author Emily
     */
    public function getTotalRoles( $_FILTERS = array(), $_ORDER_BY = array() )
    {
        $_columns = array();
        $_columns[] = 'COUNT(' . $this->configModel()->uac_roles()->id . ') as total';
        return $this->model()->uac_roles()->uac_roles_text()->uac_roles_groups()->uac_roles_groups_text()->read_left_join( FALSE, $_columns, $_FILTERS, $_ORDER_BY, NULL );
    }

    /**
     * ADD ROLES GROUP
     * Add bcUAC::rbac()->model()->uac_roles_groups()
     * @param String $NAME NN VARCHAR(20)  
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addRolesGroup( $NAME, $RETURN_ID = FALSE )
    {
        $rolesCol = $this->configModel()->uac_roles_groups(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[$rolesCol->name] = array( $NAME, bcDB::TYPE_STRING );
        return $this->model()->uac_roles_groups()->write( $_columns, $RETURN_ID );
    }

    /**
     * ADD ROLES GROUP TEXT
     * Add bcUAC::rbac()->model()->uac_roles_groups_text()
     * @param Integer $GROUP_ID
     * @param Integer $LANGUAGE_ID
     * @param String $NAME
     * @param Boolean $RETURN_ID
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addRolesGroupText( $GROUP_ID, $LANGUAGE_ID, $NAME, $RETURN_ID = FALSE )
    {
        $rolesCol = $this->configModel()->uac_roles_groups_text(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[$rolesCol->group_id] = array( $GROUP_ID, bcDB::TYPE_INTEGER );
        $_columns[$rolesCol->language_id] = array( $LANGUAGE_ID, bcDB::TYPE_INTEGER );
        $_columns[$rolesCol->name] = array( $NAME, bcDB::TYPE_STRING );
        $_columns[$rolesCol->created] = array( time(), bcDB::TYPE_INTEGER );
        return $this->model()->uac_roles_groups_text()->write( $_columns, $RETURN_ID );
    }

    /**
     * UPDATE ROLES GROUP
     * Update bcUAC::rbac()->model()->uac_roles_groups() columns value by id
     * @param Integer $ID PK NN UN AI TINYINT(3) 
     * @param String $NAME NN VARCHAR(20)   
     * @return Boolean
     * @author Emily
     */
    public function updateRolesGroup( $ID, $NAME )
    {
        $rolesCol = $this->configModel()->uac_roles_groups(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[$rolesCol->name] = array( $NAME, bcDB::TYPE_STRING );
        $_filters = array();
        $_filters[$rolesCol->id] = array( '=', $ID, FALSE, NULL );
        return $this->model()->uac_roles_groups()->update( $_columns, $_filters, array(), NULL );
    }

    /**
     * UPDATE ROLES GROUP TEXT
     * Update bcUAC::rbac()->model()->uac_roles_groups() columns value by id
     * @param Integer $GROUP_ID PK NN UN AI TINYINT(3) 
     * @param Integer $LANGUAGE_ID NN UN SMALLINT(7)  
     * @param String $NAME NN VARCHAR(45)   
     * @return Boolean
     * @author Emily
     */
    public function updateRolesGroupTextByGroupandLanguageID( $GROUP_ID, $LANGUAGE_ID, $NAME )
    {
        $rolesCol = $this->configModel()->uac_roles_groups_text(); //assign RBAC Roles Model Columns
        $_columns = array();
        $_columns[$rolesCol->name] = array( $NAME, bcDB::TYPE_STRING );
        $_columns[$rolesCol->modified] = array( time(), bcDB::TYPE_INTEGER );
        $_filters = array();
        $_filters[$rolesCol->group_id] = array( '=', $GROUP_ID, bcDB::TYPE_INTEGER, 'AND' );
        $_filters[$rolesCol->language_id] = array( '=', $LANGUAGE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_groups_text()->update( $_columns, $_filters, array(), NULL );
    }

    /**
     * DELETE ROLES GROUP
     * Delete  bcUAC::rbac()->model()->uac_roles_groups() by $ID
     * @param Integer $ID PK NN UN AI TINYINT(3) 
     * @return Boolean
     * @author Emily
     */
    public function deleteRolesGroup( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_groups()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_groups()->delete( $_filters, array(), NULL );
    }

    /**
     * GET ROLES GROUP and ROLES GROUP TEXT BY ID and LANGUAGE ID
     * Get all bcUAC::rbac()->model()->uac_roles_groups() and bcUAC::rbac()->model()->uac_roles_groups_text() columns by id and language_id
     * @param Integer $ID PK NN UN AI TINYINT(3) 
     * @param Integer $LANGUAGE_ID NN UN SMALLINT(7)  
     * @return Array
     * @author Emily
     */
    public function getRolesGroupByLanguageID( $ID, $LANGUAGE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_groups()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, 'AND' );
        $_filters[$this->configModel()->uac_roles_groups_text()->language_id] = array( '=', $LANGUAGE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_groups()->uac_roles_groups_text()->read_left_join( FALSE, array(), $_filters, array(), NULL );
    }

    /**
     * GET ROLES GROUP
     * Get all bcUAC::rbac()->model()->uac_roles_groups() columns by id
     * @param Integer $ID PK NN UN AI TINYINT(3) 
     * @return Array
     * @author Emily
     */
    public function getRolesGroup( $ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_groups()->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_groups()->read( FALSE, array(), $_filters, array(), NULL );
    }

    /**
     * GET ROLES GROUPS and ROLES GROUPS TEXT
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getRolesGroups( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_roles_groups()->uac_roles_groups_text()->read_left_join( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * GET ROLES GROUPS and ROLES GROUPS TEXT BY  LANGUAGE ID
     * Get all bcUAC::rbac()->model()->uac_roles_groups() and bcUAC::rbac()->model()->uac_roles_groups_text() columns  language_id     
     * @param Integer $LANGUAGE_ID NN UN SMALLINT(7)  
     * @return Array
     * @author Emily
     */
    public function getRolesGroupsByLanguageID( $LANGUAGE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_groups_text()->language_id] = array( '=', $LANGUAGE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_groups()->uac_roles_groups_text()->read_left_join( TRUE, array(), $_filters, array(), NULL );
    }

    /**
     * GET TOTAL ROLES GROUPS and ROLES GROUPS TEXT RECORDS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @return Integer
     * @author Emily
     */
    public function getTotalRolesGroups( $_FILTERS = array(), $_ORDER_BY = array() )
    {
        $_columns = array();
        $_columns[] = 'COUNT(' . $this->configModel()->uac_roles_groups()->id . ') as total';
        return $this->model()->uac_roles_groups()->uac_roles_groups_text()->read_left_join( FALSE, $_columns, $_FILTERS, $_ORDER_BY, NULL );
    }

    /**
     * ADD ROLES DOMAINS
     * Add bcUAC::rbac()->model()->uac_roles_domains()
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @param Integer $DOMAIN_ID NN UN BIGINT(20)     
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addRolesDomain( $ROLE_ID, $DOMAIN_ID, $RETURN_ID = FALSE )
    {
        $rolesDomainsCol = $this->configModel()->uac_roles_domains(); //assign RBAC Roles Domains Model Columns
        $_columns = array();
        $_columns[$rolesDomainsCol->role_id] = array( $ROLE_ID, bcDB::TYPE_INTEGER );
        $_columns[$rolesDomainsCol->domain_id] = array( $DOMAIN_ID, bcDB::TYPE_INTEGER );
        return $this->model()->uac_roles_domains()->write( $_columns, $RETURN_ID );
    }

    /**
     * DELETE ROLES DOMAINS BY ROLE ID
     * Delete  bcUAC::rbac()->model()->uac_roles_domains() by $ROLE_ID
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @return Boolean
     * @author Emily
     */
    public function deleteRolesDomainsByRoleID( $ROLE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_domains()->role_id] = array( '=', $ROLE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_domains()->delete( $_filters, array(), NULL );
    }

    /**
     * GET ROLES DOMAINS BY ROLE ID
     * Get all bcUAC::rbac()->model()->uac_roles_domains() columns by role_id
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @return Array
     * @author Emily
     */
    public function getRolesDomainsByRoleID( $ROLE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_domains()->role_id] = array( '=', $ROLE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_domains()->read( TRUE, array(), $_filters, array(), NULL );
    }

    /**
     * ADD ROLES TEXT
     * Add bcUAC::rbac()->model()->uac_roles_text()
     * @param Integer $ROLE_ID NN UN BIGINT(20) 
     * @param Integer $LANGUAGE_ID NN UN INT(10)
     * @param String $NAME NN VARCHAR(45)
     * @param String $DESCRIPTION VARCHAR(255)     
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addRolesText( $ROLE_ID, $LANGUAGE_ID, $NAME, $DESCRIPTION, $RETURN_ID = FALSE )
    {
        $rolesTextCol = $this->configModel()->uac_roles_text(); //assign RBAC Roles Text Model Columns
        $_columns = array();
        $_columns[$rolesTextCol->role_id] = array( $ROLE_ID, bcDB::TYPE_INTEGER );
        $_columns[$rolesTextCol->language_id] = array( $LANGUAGE_ID, bcDB::TYPE_INTEGER );
        $_columns[$rolesTextCol->name] = array( $NAME, bcDB::TYPE_STRING );
        $_columns[$rolesTextCol->description] = array( $DESCRIPTION, bcDB::TYPE_STRING );
        $_columns[$rolesTextCol->created] = array( time(), bcDB::TYPE_INTEGER );
        return $this->model()->uac_roles_text()->write( $_columns, $RETURN_ID );
    }

    /**
     * UPDATE ROLES TEXT
     * Update bcUAC::rbac()->model()->uac_roles_text() columns value by $ROLE_ID and $LANGUAGE_ID
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @param Integer $LANGUAGE_ID NN UN INT(10)
     * @param String $NAME NN VARCHAR(45)
     * @param String $DESCRIPTION VARCHAR(255)
     * @return Boolean
     * @author Emily
     */
    public function updateRolesText( $ROLE_ID, $LANGUAGE_ID, $NAME, $DESCRIPTION )
    {
        $rolesTextCol = $this->configModel()->uac_roles_text(); //assign RBAC Roles Text Model Columns
        $_columns = array();
        $_columns[$rolesTextCol->name] = array( $NAME, bcDB::TYPE_STRING );
        $_columns[$rolesTextCol->description] = array( $DESCRIPTION, bcDB::TYPE_STRING );
        $_columns[$rolesTextCol->modified] = array( time(), bcDB::TYPE_INTEGER );
        $_filters = array();
        $_filters[$rolesTextCol->role_id] = array( '=', $ROLE_ID, FALSE, 'AND' );
        $_filters[$rolesTextCol->language_id] = array( '=', $LANGUAGE_ID, FALSE, NULL );
        return $this->model()->uac_roles_text()->update( $_columns, $_filters, array(), NULL );
    }

    /**
     * GET ROLES TEXT NAME
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function gteRolesTextName( $ID )
    {
        $rolesTextCol = $this->configModel()->uac_roles_text(); //assign RBAC Roles Text Model Columns
        $_columns = array();
        $_columns[] = $rolesTextCol->name;
        $_filters = array();
        $_filters[$rolesTextCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_roles_text()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$rolesTextCol->name];
    }

    /**
     * GET ROLES TEXT DESCRIPTION
     * @param Integer $ID PK NN UN AI BIGINT(20)
     * @return String
     * @author Emily
     */
    public function getRolesTextDescription( $ID )
    {
        $rolesTextCol = $this->configModel()->uac_roles_text(); //assign RBAC Roles Text Model Columns
        $_columns = array();
        $_columns[] = $rolesTextCol->description;
        $_filters = array();
        $_filters[$rolesTextCol->id] = array( '=', $ID, bcDB::TYPE_INTEGER, NULL );
        $_data = $this->model()->uac_roles_text()->read( FALSE, $_columns, $_filters, array(), NULL );
        return $_data[$rolesTextCol->description];
    }

    /**
     * GET ROLES TEXT BY ROLE ID
     * Get all bcUAC::rbac()->model()->uac_roles_text() columns by role_id
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @return Array
     * @author Emily
     */
    public function getRolesTextByRoleID( $ROLE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_text()->role_id] = array( '=', $ROLE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_text()->read( TRUE, array(), $_filters, array(), NULL );
    }

    /**
     * GET ROLES TEXT BY LANGUAGE ID
     * Get all bcUAC::rbac()->model()->uac_roles_text() columns by language_id
     * @param Integer $_LANGUAGE_ID NN UN INT(10)   
     * @return Array
     * @author Emily
     */
    public function getRolesTextByLanguageID( $_LANGUAGE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_roles_text()->language_id] = array( '=', $_LANGUAGE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_roles_text()->read( TRUE, array(), $_filters, array(), NULL );
    }

    /**
     * GET ROLES TEXTS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $OFFSET = '5,10'
     * @return Array
     * @author Emily
     */
    public function getRolesTexts( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_roles_text()->read( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * ADD PERMISSION
     * Add bcUAC::rbac()->model()->uac_permissions()
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @param String $DISPATCHER_UUID NN VARBINARY(36)     
     * @param Boolean $RETURN_ID Default FALSE
     * @return Mixed Integer|Boolean
     * @author Emily
     */
    public function addPermission( $ROLE_ID, $DISPATCHER_UUID, $RETURN_ID = FALSE )
    {
        $permissionsCol = $this->configModel()->uac_permissions(); //assign RBAC Permissions Model Columns
        $_columns = array();
        $_columns[$permissionsCol->role_id] = array( $ROLE_ID, bcDB::TYPE_INTEGER );
        $_columns[$permissionsCol->dispatcher_uuid] = array( $DISPATCHER_UUID, bcDB::TYPE_STRING );
        return $this->model()->uac_permissions()->write( $_columns, $RETURN_ID );
    }

    /**
     * DELETE PERMISSIONS BY ROLE ID
     * Delete  bcUAC::rbac()->model()->uac_permissions() by $ROLE_ID
     * @param Integer $ROLE_ID NN UN BIGINT(20) 
     * @return Boolean
     * @author Emily
     */
    public function deletePermissionsByRoleID( $ROLE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_permissions()->role_id] = array( '=', $ROLE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_permissions()->delete( $_filters, array(), NULL );
    }

    /**
     * GET PERMISSIONS BY ROLE ID
     * Get all bcUAC::rbac()->model()->uac_permissions() columns by role_id
     * @param Integer $ROLE_ID NN UN BIGINT(20)
     * @return Array
     * @author Emily
     */
    public function getPermissionsByRoleID( $ROLE_ID )
    {
        $_filters = array();
        $_filters[$this->configModel()->uac_permissions()->role_id] = array( '=', $ROLE_ID, bcDB::TYPE_INTEGER, NULL );
        return $this->model()->uac_permissions()->read( TRUE, array(), $_filters, array(), NULL );
    }

    /**
     * GET PERMISSIONS
     * @param Array $_FILTERS Default array()
     * WHERE statement constructor ie: $_FILTERS['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL) if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_ORDER_BY Default array()
     * The specific column name and the ASC or DESC order, ie: $_ORDER_BY = array('column_name', 'ASC')
     * @param String $OFFSET Default NULL
     * Start offset and record limit separated by comma ie: $limit_offset = '5,10'
     * @return Array
     * @author Emily
     */
    public function getPermissions( $_FILTERS = array(), $_ORDER_BY = array(), $OFFSET = NULL )
    {
        return $this->model()->uac_permissions()->read( TRUE, array(), $_FILTERS, $_ORDER_BY, $OFFSET );
    }

    /**
     * Check Permission against te_uac_auth_roles and te_uac_permissions if te_uac_role status = 1
     * returns FALSE is no permission to current dispatcher | array[tasks] = array empty or containing list of task_id as key and task as value associated with current dispatcher
     * @param type $AUTH_ID NN UN BIGINT(20)
     * @param type $DISPATCHER_UUID NN VARBINARY(36)
     * @return Mixed FALSE|ARRAY
     */
    public function hasPermission( $AUTH_ID, $DISPATCHER_UUID )
    {

        $tbl = bcUAC::rbac()->configModel();
        $colRoles = $tbl->uac_roles();
        $colAuthRoles = $tbl->uac_auth_roles();
        $colPermissions = $tbl->uac_permissions();

        $_columns = array();
        $_columns[] = $colRoles->id;
        $_filters = array();
        $_filters[$colRoles->status] = array( '=', 1, bcDB::TYPE_INTEGER, 'AND' );
        $_filters[$colAuthRoles->auth_id] = array( '=', $AUTH_ID, bcDB::TYPE_INTEGER, 'AND' );
        $_filters[$colPermissions->dispatcher_uuid] = array( '=', $DISPATCHER_UUID, bcDB::TYPE_STRING, NULL );
        $_data = $this->model()->uac_roles()->uac_auth_roles()->te_uac_permissions()->read_by_role_ids( FALSE, $_columns, $_filters, array(), NULL );
        if ( !empty( $_data ) ):
            return TRUE;
        endif;
        return FALSE;
    }

    /**
     * LIBRARY CONFIGURATION
     * Set before invoking bcUAC::rbac()->useNamespace( $namespace ) for the 1st time
     * Connection namespace, table and columns
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Config
     */
    public function config()
    {
        return $this->resource( 'config' );
    }

    /**
     * MODEL CONFIGURATION
     * Set before invoking bcUAC::rbac()->useNamespace( $namespace ) for the 1st time
     * Connection namespace, table and columns
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel
     */
    public function configModel()
    {
        return $this->resource( 'configModel' );
    }

    /**
     * MODEL Object
     * NOTE: returning associative DataSet column indexes are always the same names informed
     * via bcUAC::rbac()->configModel()->column_name. When using bcDB::$FQN = TRUE (recomended), then indexes within the DataSet
     * will be FQN as well. ie: $_data['mydb.tbl.column_name'], that way it's always consistent and easy to use
     * BriskCoder\Priv\DataObject\Schema to build queries and access DataSets. This will help with code consistence
     * in case any change oocurs to database, table and column names.<br>
     * TIP: When using your own models via \logic\Model layer, create properties within the Model class referencing the columns that
     * are required to the code implementation, and during object creation assign BriskCoder\Priv\DataObject\Schema to each, 
     * this way the only maintence required will be on the property assignment, if any new database column is added or removed.
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_Model
     */
    public function model()
    {
        return $this->resource( 'model' );
    }

    /**
     * Current RBAC Resources
     * @param string $TYPE Resource types(case insensitive)
     * @return mixed 
     */
    private function resource( $TYPE )
    {
        if ( !isset( $this->_ns[$this->currNS] ) ):
            //bc::debugger()->CODE = 'DB-CONN:10000';
            // bc::debugger()->_SOLUTION[] = self::$currNS;
            //bc::debugger()->invoke();
            //todo
            exit( 'Must invoke bcUAC::rbac()->useNamespace( "YourNamespace" ) before using this library' );
        endif;

        switch ( $TYPE ):
            case 'namespace':
                return $this->currNS;
            case 'config':
                return $this->_ns[$this->currNS]['config'];
            case 'configModel':
                return $this->_ns[$this->currNS]['configModel'];
            case 'model':
                if ( $this->_ns[$this->currNS]['model'] instanceof \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_Model ):
                    return $this->_ns[$this->currNS]['model'];
                endif;

                if ( $this->config()->STORAGE_RESOURCE === FALSE ):
                    bcDB::connection( $this->configModel()->bcDB_NS );
                    return $this->_ns[$this->currNS]['model'] = new RBAC\Model\Model( __CLASS__ );
                endif;

                if ( !$this->config()->STORAGE_RESOURCE instanceof \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_Model ):
                    //debug
                    exit( 'STORAGE_RESOURCE must implement \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_Model ' );
                endif;

                return $this->_ns[$this->currNS]['model'] = $this->config()->STORAGE_RESOURCE;
            default:
                return FALSE;
        endswitch;
    }

    /**
     * RBAC DOMAIN CONTROL
     * Starts a new authentication domain or restore an exising one based upon its namespace name.
     * Set all properties on bcUAC::rbac()->config() and bcUAC::rbac()->configModel() before starting a new auth namespace
     * ACL defines multidomains allowances or denials
     * When initializing the namespace, all settings such as bcUAC::rbac()->STORAGE_RESOURCE etc are referent
     * to the namespace in use, which means that each namespace has the ability of its own settings and definitions therefore
     * allowing multiple authentication 
     * @param mixed $NAMESPACE
     * @return bool TRUE|FALSE TRUE if namespace already exists
     */
    public function useNamespace( $NAMESPACE )
    {
        $this->currNS = $NAMESPACE;
        //authentication namespace exists?
        if ( isset( $this->_ns[$this->currNS] ) ):
            return TRUE;
        endif;

        $this->_ns[$this->currNS]['config'] = new Config( __CLASS__ );
        $this->_ns[$this->currNS]['configModel'] = new ConfigModel( __CLASS__ );
        $this->_ns[$this->currNS]['model'] = FALSE;

        return FALSE;
    }

}
