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

        return Carbon::parse($date)->format('d/m/Y H:i A');
    }
}

if (! function_exists('my_money')) {
    function my_money($amount)
    {
        return money($amount, 'MYR', true);
    }
}

if (! function_exists('hasChildRelations')) {
    /**
     * Check if object has child relations count.
     * To load the relationship count into the object, use withCount()
     * @param $object
     * @return bool
     */
    function hasChildRelations($object)
    {
        $object = $object->toArray();

        foreach ($object as $key => $value) {

            if (preg_match("/_count/i", $key)) {
                if ($value > 0) {
                    return true;
                }
            }
        }

        return false;
    }
}

if (! function_exists('current_user')) {
    function current_user()
    {
        return auth()->user();
    }
}