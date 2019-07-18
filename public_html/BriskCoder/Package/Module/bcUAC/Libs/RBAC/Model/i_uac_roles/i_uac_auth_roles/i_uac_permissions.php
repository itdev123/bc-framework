<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_auth_roles;

interface i_uac_permissions
{

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
    public function read_by_role_ids( $fetchAll, $_columns, $_filters, $_order_by, $offset );
}
