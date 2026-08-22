<?php

namespace App\Enums;

enum UserRole: string
{
    case SuperAdmin = 'super_admin';
    case InventoryManager = 'inventory_manager';
    case Employee = 'employee';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Admin',
            self::InventoryManager => 'Inventory Manager',
            self::Employee => 'Employee',
        };
    }

    /** @return array<string, string> */
    public static function options(): array
    {
        $options = [];
        foreach (self::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }

    /** @return list<string> */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function labelFor(?string $value): string
    {
        if (! $value) {
            return '—';
        }

        return self::tryFrom($value)?->label() ?? ucfirst(str_replace('_', ' ', $value));
    }
}
