<?php namespace Artesaos\Attacher\Facades;

use Illuminate\Support\Facades\Facade;

class Attacher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'attacher';
    }
}