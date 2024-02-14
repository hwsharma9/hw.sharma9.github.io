<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\HasStatus;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use Admined;
    use Loggable;
    use Encryptable;
    use HasStatus;

    protected $table = 'tbl_acl_roles';

    protected $fillable = [
        'name',
        'description',
        'guard_name',
        'used_for',
        'range',
        'status',
        'created_by',
        'updated_by'
    ];

    public function scopeBackend($query)
    {
        return $query->where('used_for', 'backend');
    }
    public function scopeFrontend($query)
    {
        return $query->where('used_for', 'frontend');
    }
    public function scopeByRole($query)
    {
        return $query->when(session('role_name'), function ($query) {
            if (session('role_name') == 'Super Admin') {
                $query->where('id', 2);
            } elseif (session('role_name') == 'System Admin') {
                $query->where('id', 3);
            } elseif (session('role_name') == 'Nodal Officer') {
                $query->where('id', 4);
            }
        });
    }

    /**
     * Get all of the access for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function access(): HasMany
    {
        return $this->hasMany(AssignUserAccess::class, 'fk_role_id ', 'id');
    }
}
