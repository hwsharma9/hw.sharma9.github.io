<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MAdminLog extends Model
{
    use HasFactory;

    protected $table = 'm_admin_logs';

    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = null;

    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'remote_address',
        'prev_data',
        'current_data',
        'created_at',
        'created_by',
    ];


    /**
     * Get the parent loggable model (user or post).
     */
    public function loggable()
    {
        return $this->morphTo();
    }
}
