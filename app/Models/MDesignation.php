<?php

namespace App\Models;

use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MDesignation extends Model
{
    use HasFactory;
    use HasStatus;

    protected $table = 'm_designations';

    protected $fillable = [
        'fk_role_id',
        'name',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
}
