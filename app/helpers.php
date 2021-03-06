<?php

/**
 *  Custom Laravel Helpers
 */

use Illuminate\Support\Carbon;
use NumberToWords\NumberToWords;

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
        $amount = (float)$amount;

        return money($amount, 'MYR', true);
    }
}

if (! function_exists('my_money_word')) {
    function my_money_word($amount, $uppercase = true)
    {
        $numberToWords = new NumberToWords();

        $numberTransformer = $numberToWords->getNumberTransformer('ms');

        $amount_breakdown = explode(".", $amount);

        $ringgit = $amount_breakdown[0];

        $sen = isset($amount_breakdown[1]) ? $amount_breakdown[1] : '00';

        if ($sen !== '00') {

            if ($uppercase) {
                $amount_word = strtoupper($numberTransformer->toWords($ringgit)) . strtoupper(' ringgit ') . strtoupper($numberTransformer->toWords($sen)) . strtoupper(' sen sahaja');
            }
            else {
                $amount_word = ucwords($numberTransformer->toWords($ringgit)) . ' ringgit ' . ucwords($numberTransformer->toWords($sen)) . ' sen sahaja';
            }

        } else {

            if ($uppercase) {
                $amount_word = strtoupper($numberTransformer->toWords($ringgit)) . strtoupper(' ringgit sahaja');
            }
            else {
                $amount_word = ucwords($numberTransformer->toWords($ringgit)) . ' ringgit sahaja';
            }
        }

        return $amount_word;
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

if (! function_exists('isSuperAdmin')) {
    function isSuperAdmin()
    {
        $superadmin_roles = ['administrator'];

        $current_user = auth()->user();

        if (!$current_user->hasRole($superadmin_roles)) {
            return false;
        }

        return true;
    }
}

if (! function_exists('currentSubdomain')) {
    function currentSubdomain()
    {
        $url_array = explode('.', parse_url(request()->url(), PHP_URL_HOST));
        $subdomain = array_get($url_array, 0, null);

        return $subdomain;
    }
}

if (! function_exists('logActivity')) {

    /**
     * Helper for Spatie Activity log
     * @param string $log_name
     * @param $description
     * @param null $model
     * @param null $user
     */
    function logActivity($log_name='default', $description, $model=null, $user=null)
    {
        $activity = activity($log_name);

        if ($model) {
            $activity = $activity->performedOn($model);
        }

        if ($user) {
            $activity = $activity->by($user);
        }

        $activity->log($description);
    }
}