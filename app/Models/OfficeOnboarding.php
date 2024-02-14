<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OfficeOnboarding extends Model
{
    use HasFactory;
    use Admined;
    use Loggable;
    use Encryptable;
    use HasStatus;

    protected $table = 'tbl_office_onboardings';

    protected $fillable = [
        'fk_department_id',
        'fk_office_id',
        'nodal_name',
        'nodal_contact_number',
        'nodal_email',
        'office_address',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the department  that owns the OfficeOnboarding
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(MDepartment::class, 'fk_department_id', 'id');
    }

    /**
     * Get the office   that owns the OfficeOnboarding
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function office(): BelongsTo
    {
        return $this->belongsTo(MOffice::class, 'fk_office_id', 'id');
    }

    public function scopeFilter($query)
    {
        $filter = (array) request()->get('filter');
        $query->where(function ($query) use ($filter) {
            $query->when((isset($filter['department_id']) && !empty($filter['department_id'])), function ($query) use ($filter) {
                $query->where('fk_department_id', $filter['department_id']);
            })
                ->when((isset($filter['office_id']) && !empty($filter['office_id'])), function ($query) use ($filter) {
                    $query->where('fk_office_id', $filter['office_id']);
                })
                ->when((isset($filter['nodal_name']) && !empty($filter['nodal_name'])), function ($query) use ($filter) {
                    $query->where('nodal_name', 'like', '%' .  $filter['nodal_name'] . '%');
                })
                ->when((isset($filter['nodal_email']) && !empty($filter['nodal_email'])), function ($query) use ($filter) {
                    $query->where('nodal_email', 'like', '%' .  $filter['nodal_email'] . '%');
                })
                ->when((isset($filter['nodal_contact_number']) && !empty($filter['nodal_contact_number'])), function ($query) use ($filter) {
                    $query->where('nodal_contact_number', 'like', '%' .  $filter['nodal_contact_number'] . '%');
                })
                ->when((isset($filter['status'])), function ($query) use ($filter) {
                    $query->where('status', $filter['status']);
                });
        });
    }
}
