<?php

namespace App;

/***
 * Class Permissions
 * @package App
 */
class Permissions
{
    const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_PROVIDER = 'ROLE_PROVIDER';
    const ROLE_CUSTOMER = 'ROLE_CUSTOMER';

    /**
     * @var array
     */
    protected static $roleHierarchy = [
        self::ROLE_SUPER_ADMIN => ['*'],
        self::ROLE_ADMIN => ['*'],
        // self::ROLE_MANAGEMENT => [
        //     self::ROLE_ACCOUNT_MANAGER,
        //     self::ROLE_FINANCE,
        //     self::ROLE_SUPPORT,
        // ],
        // self::ROLE_ACCOUNT_MANAGER => [
        //     self::ROLE_SUPPORT
        // ],
        // self::ROLE_FINANCE => [
        //     self::ROLE_SUPPORT
        // ],
        // self::ROLE_SUPPORT => []
    ];

    /**
     * @param string $role
     * @return array
     */
    public static function getAllowedRoles(string $role)
    {
        if (isset(self::$roleHierarchy[$role])) {
            return self::$roleHierarchy[$role];
        }

        return [];
    }

    /***
     * @return array
     */
    public static function getRoleList()
    {
        return [
            static::ROLE_SUPER_ADMIN => 'SuperAdmin',
            static::ROLE_ADMIN => 'Admin',
            // static::ROLE_MANAGEMENT => 'Management',
            // static::ROLE_ACCOUNT_MANAGER => 'Account Manager',
            // static::ROLE_FINANCE => 'Finance',
            // static::ROLE_SUPPORT => 'Support',
        ];
    }
}
