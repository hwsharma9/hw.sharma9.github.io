<?php

namespace App\Models;

use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class MDepartment extends Model
{
    use Encryptable;
    use SoftDeletes;
    use HasStatus;

    protected $fillable = [
        'title_hi',
        'title_en',
        'status',
    ];

    /**
     * Get all of the offices for the MDepartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offices(): HasMany
    {
        return $this->hasMany(MOffice::class, 'fk_department_id', 'id');
    }

    /**
     * Get all of the categories for the MDepartment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function categories(): HasMany
    {
        return $this->hasMany(MCourseCategory::class, 'fk_department_id', 'id');
    }
}
