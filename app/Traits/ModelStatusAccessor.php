<?php

namespace App\Traits;

trait ModelStatusAccessor
{
    public function getLatestStatusAttribute()
    {
        return $this->status();
    }

    public function getLatestStatusNameAttribute()
    {
        return $this->status;
    }

    public function getLatestStatusRemarksAttribute()
    {
        return $this->status()->reason ?? null;
    }

    public function getLatestStatusCausedBy()
    {
        return $this->status()->caused_by ?? null;
    }
}