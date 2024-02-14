<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class AssignUserAccess extends Model
{
    use HasFactory;
    use Admined;
    use Encryptable;

    protected $table = 'tbl_assign_user_accesses';

    protected $fillable = [
        'fk_role_id',
        'fk_controller_id',
        'status',
        'created_by',
        'updated_by'
    ];

    /**
     * Get the role that owns the AssignUserAccess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'fk_role_id', 'id');
    }

    /**
     * Get the tblController that owns the AssignUserAccess
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tblController(): BelongsTo
    {
        return $this->belongsTo(DbController::class, 'fk_controller_id', 'id');
    }
}
