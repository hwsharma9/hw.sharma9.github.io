<?php

namespace App\Models;

use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    use HasFactory;
    use HasStatus;

    protected $table = 'tbl_pages';

    protected $fillable = [
        'title_hi',
        'description_hi',
        'title_en',
        'description_en',
        'pre_url',
        'slug',
        'added_date',
        'added_by',
        'edit_date',
        'edit_by',
        'status',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'is_default',
        'is_delete',
        'is_on_homepage',
        'banner',
        'is_sidebar',
        'sidebar_id'
    ];

    protected $attributes = [
        'sidebar_id' => 0
    ];
}
