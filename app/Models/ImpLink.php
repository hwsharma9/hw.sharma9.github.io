<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImpLink extends Model
{
    use HasFactory;
    use Admined;
    use Encryptable;

    protected $table = 'tbl_imp_links';

    protected $fillable = [
        'title_hi',
        'title_en',
        'menu_type',
        'fk_controller_route_id',
        'fk_page_id',
        'custom_url',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
