<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdminMenu extends Model
{
    use HasFactory;

    protected $table = 'tbl_admin_menus';

    protected $fillable = [
        'menu_name',
        'controller_name',
        'icon_class',
        'parent_id',
        's_order',
        'class_id',
        'params',
        'action',
        'tab_same_new',
        'is_active',
        'fk_tbl_acl_permission_id'
    ];

    protected $with = ['child'];

    /**
     * Get all of the child for the Child
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child(): HasMany
    {
        return $this->hasMany(AdminMenu::class, 'parent_id', 'id')->with('permission')->orderBy('s_order', 'asc');
    }

    /**
     * Get all of the child for the Child
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child_with_permission(): HasMany
    {
        return $this->hasMany(AdminMenu::class, 'parent_id', 'id')
            ->whereNotNull('permission_id')
            ->with([
                'child_with_permission' => function ($query) {
                    $query->whereHas('permission');
                }
            ])
            ->orderBy('s_order', 'asc');
    }

    /**
     * Get the permission that owns the AdminMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function permission(): BelongsTo
    {
        return $this->belongsTo(Permission::class, 'fk_tbl_acl_permission_id', 'id');
    }
}
