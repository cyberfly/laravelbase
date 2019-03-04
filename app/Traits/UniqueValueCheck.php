<?php

namespace App\Traits;

trait UniqueValueCheck
{
    /**
     * Check if value passed is unique in the model
     * Use for ajax check such as serial_no, ic_no etc
     * @param $request_data
     * @param $query
     * @return \Illuminate\Support\Collection
     */
    public function checkUniqueValue($request_data, $query)
    {
        $unique_key = data_get($request_data, 'unique_key');
        $unique_value = data_get($request_data, 'unique_value');
        $except_key = data_get($request_data, 'except_key');
        $except_value = data_get($request_data, 'except_value');

        $model = $query
            ->where($unique_key, $unique_value);

        // if we want to exclude specific id from checking, suitable for edit operation

        if (!empty($except_value)) {
            $model = $model->where($except_key, '!=', $except_value);
        }

        $model = $model->first();

        if ($model) {
            $valid = false;
            $message = $unique_key . ' is already taken';
        }
        else {
            $valid = true;
            $message = null;
        }

        $result = collect([
            'valid' => $valid,
            'message' => $message,
        ]);

        return $result;
    }
}