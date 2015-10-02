<?php

namespace EShop\Config;

final class AppUserRolesConfig
{
    const DEFAULT_USER_ROLE = 2;        // Editor user role
    const ADMIN_ROLE = 'Admin';
    const EDITOR_ROLE = 'Editor';
    const GUEST_ROLE = 'Guest';

    // ADD Role Id and their corresponding names from the Database
    public static function getUserRoleName($roleId)
    {
        switch($roleId) {
            case '1':
                return self::ADMIN_ROLE;
            case '2':
                return self::EDITOR_ROLE;
            case '3':
                return self::GUEST_ROLE;
            default:
                return 'Invalid user role id';
        }
    }

    public static function hasAddEditDeletePriviligies()
    {
        switch($_SESSION['role']) {
            case self::ADMIN_ROLE: return true;
            case self::EDITOR_ROLE: return true;
        }
        return false;
    }
}