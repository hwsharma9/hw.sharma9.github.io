<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\Encryptable;
use App\Http\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class DbController extends Model
{
    use HasFactory;
    use Admined;
    use Loggable;
    use Encryptable;

    protected $table = 'tbl_acl_controllers';

    protected $fillable = [
        'title',
        'resides_at',
        'controller_name',
        'status',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    /**
     * Get all of the routes for the DBController
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dbControllerRoute(): HasMany
    {
        return $this->hasMany(DbControllerRoute::class, 'fk_controller_id', 'id');
    }

    /**
     * Get all of the permissions for the DbController
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function permissions(): HasManyThrough
    {
        return $this->hasManyThrough(Permission::class, DbControllerRoute::class, 'fk_controller_id', 'fk_controller_route_id', 'id', 'id');
    }
}
