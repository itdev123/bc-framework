<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model;

interface i_Model
{

    /**
     * uac_auth_roles TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_auth_roles
     */
    public function uac_auth_roles();

    /**
     * uac_permissions TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_permissions
     */
    public function uac_permissions();

    /**
     * uac_roles TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles
     */
    public function uac_roles();

    /**
     * uac_roles_text TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_text
     */
    public function uac_roles_text();

    /**
     * uac_roles_groups TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_groups
     */
    public function uac_roles_groups();

    /**
     * uac_roles_groups_text TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_groups_text
     */
    public function uac_roles_groups_text();

    /**
     * uac_roles_domains TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles_domains
     */
    public function uac_roles_domains();
}
