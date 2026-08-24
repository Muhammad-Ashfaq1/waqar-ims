<?php

namespace App\Enums;

enum LocationType: string
{
    case Town = 'town';
    case Workshop = 'workshop';

    public function label(): string
    {
        return match ($this) {
            self::Town => 'Town',
            self::Workshop => 'Workshop',
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
}
