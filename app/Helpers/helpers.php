<?php

/**
 * Get roleId (user_group) for User by roleName
 * @param $roleName
 * @return int
 * @throws Exception
 */
function getRoleId($roleName){
    $roleId = config('dleconfig.roles_user.' . $roleName);

    if (is_null($roleId)) {
        throw new Exception('RoleId not found by roleName ' . $roleName);
    }

    return (int)$roleId;
}