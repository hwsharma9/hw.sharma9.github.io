<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontMenuModule extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tbl_front_menu_modules';
}
