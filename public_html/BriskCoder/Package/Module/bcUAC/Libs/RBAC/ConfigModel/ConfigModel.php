<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC;

use BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRoles,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesText,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesGroups,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesGroupsText,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesDomains,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableAuthRoles,
    BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TablePermissions;

final class ConfigModel
{

    public
    /**
     * bcDB Connection NAMESPACE
     * Used with bcDB Library only
     * @var string $bcDB_NS
     */
            $bcDB_NS,
            /**
             * TABLE uac_roles
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_roles,
            /**
             * TABLE uac_roles_text
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_roles_text,
            /**
             * TABLE uac_roles_groups
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_roles_groups,
            /**
             * TABLE uac_roles_groups_text
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_roles_groups_text,
            /**
             * TABLE uac_roles_domains
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_roles_domains,
            /**
             * TABLE uac_auth_roles
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_auth_roles,
            /**
             * TABLE uac_permissions
             * Execute bcDB::architect after creating module tables then 
             * invoke BriskCoder\Priv\Schema to assign values.
             */
            $tbl_uac_permissions;

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * Table Roles Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRoles
     */
    public function uac_roles()
    {
        static $obj;
        return $obj instanceof TableRoles ? $obj : $obj = new TableRoles( __CLASS__ );
    }

    /**
     * Table Roles Text Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesText
     */
    public function uac_roles_text()
    {
        static $obj;
        return $obj instanceof TableRolesText ? $obj : $obj = new TableRolesText( __CLASS__ );
    }

    /**
     * Table Roles Groups Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesGroups
     */
    public function uac_roles_groups()
    {
        static $obj;
        return $obj instanceof TableRolesGroups ? $obj : $obj = new TableRolesGroups( __CLASS__ );
    }

    /**
     * Table Roles Groups Text Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesGroupsText
     */
    public function uac_roles_groups_text()
    {
        static $obj;
        return $obj instanceof TableRolesGroupsText ? $obj : $obj = new TableRolesGroupsText( __CLASS__ );
    }

    /**
     * Table Roles Domains Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableRolesDomains
     */
    public function uac_roles_domains()
    {
        static $obj;
        return $obj instanceof TableRolesDomains ? $obj : $obj = new TableRolesDomains( __CLASS__ );
    }

    /**
     * Table Auth Roles Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TableAuthRoles
     */
    public function uac_auth_roles()
    {
        static $obj;
        return $obj instanceof TableAuthRoles ? $obj : $obj = new TableAuthRoles( __CLASS__ );
    }

    /**
     * Table Permissions Columns
     * @static $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\ConfigModel\TablePermissions
     */
    public function uac_permissions()
    {
        static $obj;
        return $obj instanceof TablePermissions ? $obj : $obj = new TablePermissions( __CLASS__ );
    }

}
