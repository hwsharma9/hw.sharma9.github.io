<?php

namespace App\Models;

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
}
