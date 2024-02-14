<?php

namespace App\Models;

use App\Http\Traits\Admined;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class DbControllerRoute extends Model
{
    use HasFactory;
    use Admined;

    protected $table = 'tbl_acl_controller_routes';

    protected $fillable = [
        'route',
        'named_route',
        'method',
        'function_name',
        'fk_controller_id',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the permission associated with the DatabaseRoute
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission(): HasOne
    {
        return $this->hasOne(Permission::class, 'fk_controller_route_id', 'id');
    }

    /**
     * Get the controller that owns the DbControllerRoute
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbController(): BelongsTo
    {
        return $this->belongsTo(DbController::class, 'fk_controller_id', 'id');
    }

    /**
     * Get the AssignUserAccess associated with the DbControllerRoute
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function assignUserAccess(): HasOne
    {
        return $this->hasOne(AssignUserAccess::class, 'fk_controller_id', 'fk_controller_id');
    }
}
