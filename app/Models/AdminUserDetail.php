<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminUserDetail extends Model
{
    use Admined;
    use Loggable;

    protected $table = 'tbl_admin_user_details';

    protected $fillable = [
        'id',
        'fk_admin_id',
        'employee_id',
        'fk_office_onboarding_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the officeonboarding that owns the Admin
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function officeonboarding(): BelongsTo
    {
        return $this->belongsTo(OfficeOnboarding::class, 'fk_office_onboarding_id', 'id');
    }
}
