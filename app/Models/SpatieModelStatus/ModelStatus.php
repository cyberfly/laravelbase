<?php

namespace App\Models\SpatieModelStatus;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Spatie\ModelStatus\Status as SpatieModelStatus;

class ModelStatus extends SpatieModelStatus
{
    use SoftDeletes;

    protected $with = [
        'causedBy',
    ];

    public static function boot()
    {
        static::creating(function(ModelStatus $status) {

            $causer_id = null;

            if (!empty(session('causer_id'))) {
                $causer_id = session()->pull('causer_id');
            }
            else {
                $causer_id = optional(auth()->user())->id;
            }

            $status->causer_id = $causer_id;
        });
    }

    public function causedBy()
    {
        return $this->belongsTo(User::class,'causer_id', 'id');
    }
}
