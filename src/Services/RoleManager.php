<?php


namespace App\Services;


class RoleManager
{
    public static $ROLES = [
        'ADMIN',
        'USER',
        'SELLER',
        'COLLECTOR',
        'PROFESSIONAL-COLLECTOR'
    ];

    public const DEFAULT = 'USER';
    private const ROLE_PREFIX = 'ROLE_';

    public function getDefaultRole(): string
    {
        return self::ROLE_PREFIX . self::DEFAULT;
    }

    public function getRole(string $role)
    {
        if (!$this->roleExist($role)) {
            return $this->getDefaultRole();
        }

        return self::ROLE_PREFIX . $role;
    }

    public function getRoles($role): array
    {
        if (\is_array($role)) {
            foreach ($role as $index => $name) {
                if ($this->roleExist($name)) {
                    $role[] = self::ROLE_PREFIX . $name;
                }
                unset($role[$index]);
            }

            return $role;
        }

        if (!$this->roleExist($role)) {
            return [];
        }

        return [self::ROLE_PREFIX . $role];
    }

    public function roleExist($role)
    {
        return \in_array($role, self::$ROLES);
    }
}