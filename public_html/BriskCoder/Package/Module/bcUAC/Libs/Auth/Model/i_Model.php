<?php

namespace BriskCoder\Package\Module\bcUAC\Libs\Auth\Model;

interface i_Model
{

    /**
     * uac_auth TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_uac_auth
     */
    public function uac_auth();

    /**
     * uac_auth_lock TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_uac_auth_lock
     */
    public function uac_auth_lock();

    /**
     * uac_auth_questions TABLE AS SQL OBJECT
     * @staticvar Object $obj
     * @return \BriskCoder\Package\Module\bcUAC\Libs\Auth\Model\i_uac_auth_questions
     */
    public function uac_auth_questions();
}