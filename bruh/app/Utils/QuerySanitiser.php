<?php

namespace App\Utils;

class QuerySanitiser
{
    public static function sanitise(string $rawQuery): string
    {
        return htmlspecialchars($rawQuery, ENT_QUOTES, 'UTF-8');
    }
}
