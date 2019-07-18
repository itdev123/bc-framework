<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles;

interface i_uac_auth_roles
{
    /**
     * uac_roles RIGHT JOIN uac_auth_roles ON $colRoles->id  = $colAuthRoles->role_id<br>
     * RIGHT JOIN uac_permissions ON $colAuthRoles->role_id  = $colPermissions->role_id  AS TABLE SQL OBJECT
     * @staticvar Object $uac_permissions
     * @return \BriskCoder\Package\Module\bcUAC\Libs\RBAC\Model\i_uac_roles\i_uac_auth_roles\i_uac_permissions     
     */
    public function te_uac_permissions();
}
