<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_roles_text;

interface i_uac_roles_groups
{

    /**
     * uac_roles LEFT JOIN uac_roles_text ON $colRoles->id = $colRolesText->role_id<br>
     * LEFT JOIN uac_roles_groups ON $colRoles->group_id = $colRolesGroups->id  AS TABLE SQL OBJECT     
     * @param Boolen $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Array Returns table columns from joins with alias 'permission'=0|1
     */
    public function read_left_join( $fetchAll, $_columns, $_filters, $_order_by, $offset );

    /**
     * uac_roles_groups_text
     * @staticvar Object $uac_roles_groups_text
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_roles_text\i_uac_roles_groups\i_uac_roles_groups_text   
     */
    public function uac_roles_groups_text();
}
