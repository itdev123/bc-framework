<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model;

interface i_uac_roles_groups
{

    /**
     * uac_roles_groups TABLE SQL DELETE OPERATION
     * @param Array $_filters WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Mixed
     */
    public function delete( $_filters, $_order_by, $offset );

    /**
     * uac_roles_groups TABLE SQL READ OPERATION
     * @param Boolean $fetchAll TRUE=fetchAll|FALSE=fetchRow
     * @param Array $_columns DB Columns to return, ie: $_columns[] = schema\table_name::column_name
     * @param Array $_filters  WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Array
     */
    public function read( $fetchAll, $_columns, $_filters, $_order_by, $offset );

    /**
     * uac_roles_groups TABLE SQL UPDATE OPERATION
     * @param Array $_columns SET statement constructor <br>
     * ie: $_columns[schema\table_name::column_name] =  array(value, schema::$TYPE_?|FALSE) <br>
     * if 2nd paramenter is FALSE then value is not bound.
     * @param Array $_filters WHERE statement constructor ie: <br>
     * $_filters['column'] = Array(comparison operator, value, schema::$TYPE_?|FALSE, logical operator|NULL)<br>
     * if 3rd paramenter is FALSE then value is not bound.
     * @param Array $_order_by The specific column name and the ASC or DESC order, ie: $_order_by = array('column_name', 'ASC')
     * @param String $offset Start offset and record limit separated by comma ie: $offset = '5,10'
     * @return Mixed
     */
    public function update( $_columns, $_filters, $_order_by, $offset );

    /**
     * uac_roles_groups TABLE SQL WRITE OPERATION
     * @param Array $_columns SET statement constructor ie: <br>
     * $_columns['column'] =  Array(value, schema::$TYPE_?|FALSE)<br>
     *  if 2nd paramenter is FALSE then value is not bound.
     * @param Boolean $last_id Return Last Inserted Id <br>
     * @return Mixed
     */
    public function write( $_columns, $last_id );

    /**
     * uac_roles_groups_text TABLE AS SQL OBJECT
     * @staticvar Object $uac_roles_groups_text
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_groups\i_uac_roles_groups_text
     */
    public function uac_roles_groups_text();
}
