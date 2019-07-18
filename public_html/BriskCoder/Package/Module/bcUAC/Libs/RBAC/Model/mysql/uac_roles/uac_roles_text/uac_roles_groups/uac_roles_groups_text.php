<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles\uac_roles_text\uac_roles_groups;

use BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Library\bcCache;

final class uac_roles_groups_text implements \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_roles_text\i_uac_roles_groups\i_uac_roles_groups_text
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles\uac_roles_text\uac_roles_groups' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
        //cache defaults
        bcCache::$STORAGE_RESOURCE = FALSE;
        bcCache::$LIFE_DEFAULT = 31536000; //year
        bcCache::$ENCODING = 2; //serialize
    }

    /**
     * uac_roles LEFT JOIN uac_roles_text ON $colRoles->id = $colRolesText->role_id<br>
     * LEFT JOIN uac_roles_groups ON $colRoles->group_id = $colRolesGroups->id  AS TABLE SQL OBJECT     
     * LEFT JOIN uac_roles_groups_text ON $colRolesGroups->id = $colRolesGroupsText->group_id  AS TABLE SQL OBJECT     
     * @param Boolen $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Array Returns table columns from joins with alias 'permission'=0|1
     */
    public function read_left_join( $fetchAll, $_columns, $_filters, $_order_by, $offset )
    {
        $tbl = bcUAC::rbac()->configModel();
        $colRoles = $tbl->uac_roles();
        $colRolesText = $tbl->uac_roles_text();
        $colRolesGroups = $tbl->uac_roles_groups();
        $colRolesGroupsText = $tbl->uac_roles_groups_text();
        bcCache::useNamespace( $tbl->tbl_uac_roles . '_' . $tbl->tbl_uac_roles_text . '_' . $tbl->tbl_uac_roles_groups . '_' . $tbl->tbl_uac_roles_groups_text );
        $cacheKey = md5( 'SELECT' . $fetchAll . serialize( $_columns ) . serialize( $_filters ) . serialize( $_order_by ) . $offset );
        $_data = bcCache::read( $cacheKey );
        if ( $_data ):
            return $_data;
        endif;
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->select( $_columns, $tbl->tbl_uac_roles );
        bcDB::mapper()->join( array( 'LEFT' => array( $tbl->tbl_uac_roles_text, $colRoles->id, '=', $colRolesText->role_id ) ) );
        bcDB::mapper()->join( array( 'LEFT' => array( $tbl->tbl_uac_roles_groups, $colRoles->group_id, '=', $colRolesGroups->id ) ) );
        bcDB::mapper()->join( array( 'LEFT' => array( $tbl->tbl_uac_roles_groups_text, $colRolesGroups->id, '=', $colRolesGroupsText->group_id ) ) );     
        bcDB::mapper()->where( $_filters );
        bcDB::mapper()->orderBy( $_order_by );
        bcDB::mapper()->limit( $offset );
        $_data = bcDB::mapper()->fetch( $fetchAll );
        bcCache::write( $cacheKey, $_data );
        return $_data;
    }

}
