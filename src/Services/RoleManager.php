<?php


namespace App\Services;


class RoleManager
{
    const ROLE_ADMIN = "ADMIN";
    const ROLE_USER = "USER";
    const ROLE_COLLECTOR = "COLLECTOR";
    const ROLE_PROFESSIONAL = "PROFESSIONAL";

    const PREFIX = "ROLE_";

    public function getRole(string $role): string
    {
        return self::PREFIX.$role;
    }
}