<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorLog extends Model
{
    protected $table = 'tbl_error_logs';

    protected $fillable = [
        'class_name',
        'function_name',
        'error',
        'created_at',
        'updated_at',
    ];
}
