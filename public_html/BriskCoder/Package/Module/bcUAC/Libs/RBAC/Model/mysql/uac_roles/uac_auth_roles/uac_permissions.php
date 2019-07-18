<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles\uac_auth_roles;

use BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Library\bcCache;

class uac_permissions implements \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_auth_roles\i_uac_permissions
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles\uac_auth_roles' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
        //cache defaults
        bcCache::$STORAGE_RESOURCE = FALSE;
        bcCache::$LIFE_DEFAULT = 31536000; //year
        bcCache::$ENCODING = 2; //serialize
    }

    /**
     * GET PERMISSION using<br>
     * uac_roles RIGHT JOIN uac_auth_roles ON $colRoles->id = $colAuthRoles->role_id<br>
     * RIGHT JOIN uac_permissions ON $colAuthRoles->role_id = $colPermissions->role_id  AS TABLE SQL OBJECT     
     * @param Boolen $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Array Returns table columns from joins with alias 'permission'=0|1
     */
    public function read_by_role_ids( $fetchAll, $_columns, $_filters, $_order_by, $offset )
    {
        $tbl = bcUAC::rbac()->configModel();
        $colRoles = $tbl->uac_roles();
        $colAuthRoles = $tbl->uac_auth_roles();
        $colPermissions = $tbl->uac_permissions();
        bcCache::useNamespace( $tbl->tbl_uac_roles . '_' . $tbl->tbl_uac_auth_roles . '_' . $tbl->tbl_uac_permissions );
        $cacheKey = md5( 'SELECT' . $fetchAll . serialize( $_columns ) . serialize( $_filters ) . serialize( $_order_by ) . $offset );
        $_data = bcCache::read( $cacheKey );
        if ( $_data ):
            return $_data;
        endif;
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->select( $_columns, $tbl->tbl_uac_roles );
        bcDB::mapper()->join( array( 'RIGHT' => array( $tbl->tbl_uac_auth_roles, $colRoles->id, '=', $colAuthRoles->role_id ) ) );
        bcDB::mapper()->join( array( 'RIGHT' => array( $tbl->tbl_uac_permissions, $colAuthRoles->role_id, '=', $colPermissions->role_id ) ) );
        bcDB::mapper()->where( $_filters );
        bcDB::mapper()->orderBy( $_order_by );
        bcDB::mapper()->limit( $offset );
        $_data = bcDB::mapper()->fetch( $fetchAll );
        bcCache::write( $cacheKey, $_data );
        return $_data;
    }

}
