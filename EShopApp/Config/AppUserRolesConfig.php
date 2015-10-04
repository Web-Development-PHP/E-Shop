<?php

namespace EShop\Config;

final class AppUserRolesConfig
{
    const DEFAULT_USER_ROLE = 3;        // User user role
    const ADMIN_ROLE = 'Admin';
    const EDITOR_ROLE = 'Editor';
    const USER_ROLE = 'User';

    // ADD Role Id and their corresponding names from the Database
    public static function getUserRoleName($roleId)
    {
        switch($roleId) {
            case '1':
                return self::ADMIN_ROLE;
            case '2':
                return self::EDITOR_ROLE;
            case '3':
                return self::USER_ROLE;
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

    public static function isAdmin()
    {
        if($_SESSION['role'] == AppUserRolesConfig::ADMIN_ROLE) {
            return true;
        }
        return false;
    }
}