<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles_groups;

use BriskCoder\Package\Module\bcUAC,
    BriskCoder\Package\Library\bcDB,
    BriskCoder\Package\Library\bcCache;

final class uac_roles_groups_text implements \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_groups\i_uac_roles_groups_text
{

    public function __construct( $CALLER )
    {
        if ( $CALLER !== 'BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\mysql\uac_roles_groups' ):
            exit( 'DEBUG: forbidden use of internal class class: ' . __CLASS__ );
        endif;
    }

    /**
     * uac_roles_groups LEFT JOIN uac_roles_groups_text ON  uac_roles_groups_id = uac_roles_groups_text_roles_group_id TABLE SQL READ OPERATION
     * @param Boolen $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Array
     */
    public function read_left_join( $fetchAll, $_columns, $_filters, $_order_by, $offset )
    {

        $tbl = bcUAC::rbac()->configModel();
        $colRoles = $tbl->uac_roles_groups();
        $colRolesText = $tbl->uac_roles_groups_text();

        bcCache::useNamespace( $tbl->tbl_uac_roles_groups . '_' . $tbl->tbl_uac_roles_groups_text );
        $cacheKey = md5( 'SELECT' . $fetchAll . serialize( $_columns ) . serialize( $_filters ) . serialize( $_order_by ) . $offset );
        $_data = bcCache::read( $cacheKey );
        if ( $_data ):
            return $_data;
        endif;
        bcDB::connection( $tbl->bcDB_NS );
        bcDB::mapper()->select( $_columns, $tbl->tbl_uac_roles_groups );
        bcDB::mapper()->join( array( 'LEFT' => array( $tbl->tbl_uac_roles_groups_text, $colRoles->id, '=', $colRolesText->group_id ) ) );
        bcDB::mapper()->where( $_filters );
        bcDB::mapper()->orderBy( $_order_by );
        bcDB::mapper()->limit( $offset );
        $_data = bcDB::mapper()->fetch( $fetchAll );

        bcCache::write( $cacheKey, $_data );

        return $_data;
    }

}
