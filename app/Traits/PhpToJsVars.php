<?php

namespace App\Traits;

trait PhpToJsVars
{
    protected function getPhpToJsVariables()
    {
        return [
            'user' => auth()->user(),
            'general' => [
                'site_name' => config('app.name'),
                'environment' => config('app.env'),
            ],
        ];
    }
}