<?php

namespace App\Controllers\Api;

use Phalcon\Http\Response;

interface ApiActionInterface
{
    public static function exec($app, ...$params): Response;
}