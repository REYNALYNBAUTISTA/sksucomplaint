<?php

namespace App\Enums;

enum Roles: int
{
   case STUDENT = 1;
    case OFFICE_PERSONNEL = 2;
    case ADMIN = 3;
    case SUPER_ADMIN = 4;

    // Optional: Add a helper method to get a display name for the UI
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::STUDENT => 'Student',
            self::OFFICE_PERSONNEL => 'Office Personnel',
            self::ADMIN => 'System Admin',
            self::SUPER_ADMIN => 'Super Admin',
        };
    }
}
