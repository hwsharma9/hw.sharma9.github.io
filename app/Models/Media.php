<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Uploadable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Media extends Model
{
    use HasFactory;
    use Admined;
    use Uploadable;

    protected $table = 'tbl_media';

    protected $fillable = ['created_by', 'updated_by'];
}
