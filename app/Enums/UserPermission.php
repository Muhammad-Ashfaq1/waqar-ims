<?php

namespace App\Enums;

enum UserPermission: string
{
    case UsersManage = 'users.manage';
    case BaseDataManage = 'base-data.manage';
    case InventoryManage = 'inventory.manage';

    /** @return list<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
