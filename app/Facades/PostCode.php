<?php

namespace App\Facades;

use App\Services\PostCodeService;
use Illuminate\Support\Facades\Facade;

class PostCode extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return PostCodeService::class;
    }
}
