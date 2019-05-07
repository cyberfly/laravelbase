<?php

namespace App\Traits;

trait PhpToJsVars
{
    protected function getPhpToJsVariables()
    {
        return [
            'general' => [
                'site_name' => config('app.name'),
                'environment' => config('app.env'),
            ],
        ];
    }
}