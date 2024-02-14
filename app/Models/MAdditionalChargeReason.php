<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAdditionalChargeReason extends Model
{
    use HasFactory;

    protected $table = 'm_additional_charge_reasons';

    protected $fillable = [
        'name',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
