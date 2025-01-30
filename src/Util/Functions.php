<?php

namespace App\Util;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

class Functions extends AbstractController
{
    public static function getPost($key)
    {
        return $_POST[$key] ?? null;
    }
}
