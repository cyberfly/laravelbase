<?php

/**
 *  Custom Laravel Helpers
 */

use Illuminate\Support\Carbon;

if (! function_exists('carbon')) {
    function carbon($parseString = null, $tz = null)
    {
        return new Carbon($parseString, $tz);
    }
}

if (! function_exists('my_date')) {
    function my_date($date)
    {
        if (empty($date)) {
            return '-';
        }

        return Carbon::parse($date)->format('d/m/Y');
    }
}

if (! function_exists('my_datetime')) {
    function my_datetime($date)
    {
        if (empty($date)) {
            return '-';
        }

        return Carbon::parse($date)->format('d/m/Y H:i:s');
    }
}

if (! function_exists('my_money')) {
    function my_money($amount)
    {
        return money($amount, 'MYR', true);
    }
}