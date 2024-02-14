<?php

namespace App\Models;

use App\Http\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Models\Permission as ModelsPermission;

class Permission extends ModelsPermission
{
    use Encryptable;
    protected $table = 'tbl_acl_permissions';

    protected $fillable = ['name', 'guard_name', 'fk_controller_route_id'];

    /**
     * Get the dbControllerRoute associated with the Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbControllerRoute(): belongsTo
    {
        return $this->belongsTo(DbControllerRoute::class, 'fk_controller_route_id', 'id');
    }
}
