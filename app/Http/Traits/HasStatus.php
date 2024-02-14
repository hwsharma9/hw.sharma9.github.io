<?php

namespace App\Http\Traits;

trait HasStatus
{
    public function scopePending($query)
    {
        return $query->where('status', 0);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', 2);
    }
}
