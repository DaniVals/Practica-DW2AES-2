<?php

namespace App\Util;

class Functions
{
    public static function getPost($key)
    {
        return $_POST[$key] ?? null;
    }
}
