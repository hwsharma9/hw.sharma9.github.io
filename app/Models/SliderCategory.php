<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SliderCategory extends Model
{
    use HasFactory;

    protected $table = 'm_slider_categories';

    protected $fillable = ['cat_title_en'];
}
