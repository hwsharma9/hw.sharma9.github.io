<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use App\Http\Traits\Uploadable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminRole extends Model
{
    use Admined;
    use Encryptable;
    use Uploadable;
    use Loggable;
    use HasStatus;

    protected $table = 'tbl_admin_roles';

    protected $fillable = [
        'actual_admin_user_id',
        'fk_user_id',
        'fk_role_id',
        'from_date',
        'to_date',
        'status',
        'remark',
        'is_default',
        'fk_reason_id',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    protected $with = ['role'];

    /**
     * Get the admin that owns the AdminRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'fk_user_id', 'id');
    }

    /**
     * Get the actual_admin that owns the AdminRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function actual_admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'actual_admin_user_id', 'id');
    }

    /**
     * Get the role that owns the UserRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'fk_role_id', 'id');
    }

    /**
     * Get the reason that owns the UserRole
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function reason(): BelongsTo
    {
        return $this->belongsTo(MAdditionalChargeReason::class, 'fk_reason_id', 'id');
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(
            function ($query) use ($filter) {
            }
        );
    }
}
