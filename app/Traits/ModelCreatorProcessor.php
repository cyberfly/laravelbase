<?php

namespace App\Traits;

use App\User;

trait ModelCreatorProcessor
{
    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }

    public function processedByUser()
    {
        return $this->belongsTo(User::class, 'processed_by', 'id');
    }
}