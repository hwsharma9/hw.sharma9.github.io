<?php

namespace App\Models;

use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDepartment extends Model
{
    use SoftDeletes;
    use HasStatus;

    protected $fillable = [
        'title_hi',
        'title_en',
        'status',
    ];
}
