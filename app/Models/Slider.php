<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
{
    use HasFactory;
    use Admined;
    use Uploadable;

    protected $table = 'tbl_sliders';

    protected $fillable = [
        'title_hi',
        'title_en',
        'menu_type',
        'fk_slider_category_id',
        'fk_controller_route_id',
        'fk_page_id',
        'custom_url',
        'order_preference',
        // 'published_at',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];
}
