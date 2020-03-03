<?php


namespace App\Services;


class RoleManager
{
    const ADMIN = "ADMIN";
    const USER = "USER";
    const SELLER = "SELLER";
    const COLLECTOR = "COLLECTOR";
    const PROFESSIONAL_COLLECTOR = "PROFESSIONAL-COLLECTOR";
    const DEFAULT = self::USER;

    const ROLE_PREFIX = "ROLE_";

    public function getDefaultRole(): string
    {
        return self::ROLE_PREFIX.self::DEFAULT;
    }

    public function getRole(string $role): string
    {
        return self::ROLE_PREFIX.$role;
    }
}