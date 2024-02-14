<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MOffice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'fk_department_id',
        'title_en',
        'title_hi',
    ];
}
