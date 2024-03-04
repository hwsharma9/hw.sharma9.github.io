<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerificationCode extends Model
{
    use HasFactory;

    protected $table = 'tbl_verification_codes';

    public $timestamps = false;

    protected $fillable = ['verifiable_id', 'verifiable_type', 'otp', 'for', 'expire_at'];

    /**
     * Get the parent verifiable model (user or post).
     */
    public function verifiable()
    {
        return $this->morphTo();
    }

    public function scopeExpired($query)
    {
        return $query->where('expire_at', '<=', now());
    }

    public function scopeActive($query)
    {
        return $query->where('expire_at', '>=', now());
    }

    public function isExpired()
    {
        $now = Carbon::now();
        return $now->isAfter($this->expire_at);
    }

    public function isActive()
    {
        $now = Carbon::now();
        return $now->isBefore($this->expire_at);
    }

    public function scopeFor($query, $for = 'login')
    {
        return $query->where('for', '=', $for);
    }
}
