<?php

namespace App\Models;

use App\Http\Traits\Admined;
use App\Http\Traits\HasStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FrontMenu extends Model
{
    use HasFactory;
    use Admined;
    use HasStatus;

    protected $table = 'tbl_front_menus';

    protected $fillable = [
        'fk_menu_type_id',
        'fk_controller_route_id',
        'fk_page_id',
        'parent_id',
        'open_same_tab',
        'title_hi',
        'title_en',
        'menu_order',
        'status',
        'menu_type',
        'custom_url',
        'created_by',
        'updated_by',
        'created_at',
        'updated_at',
    ];

    /**
     * Get all of the child for the Child
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function child(): HasMany
    {
        return $this->hasMany(FrontMenu::class, 'parent_id', 'id')->orderBy('menu_order', 'asc');
    }

    /**
     * Get the frontMenuType that owns the FrontMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function frontMenuType(): BelongsTo
    {
        return $this->belongsTo(FrontMenuType::class, 'fk_menu_type_id', 'id');
    }

    /**
     * Get the dbControllerRoute associated with the Permission
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dbControllerRoute(): BelongsTo
    {
        return $this->belongsTo(DbControllerRoute::class, 'fk_controller_route_id', 'id');
    }

    /**
     * Get the page that owns the FrontMenu
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'fk_page_id', 'id');
    }

    public function scopeLocation($query, $type_id)
    {
        return $query->where('fk_menu_type_id', $type_id)->orderBy('menu_order', 'asc');
    }

    public function scopeTopMenu($query)
    {
        return $query->where('fk_menu_type_id', 1)->orderBy('menu_order', 'asc');
    }

    public function scopeBottomMenu($query)
    {
        return $query->where('fk_menu_type_id', 2)->orderBy('menu_order', 'asc');
    }

    public function scopeSideMenu($query)
    {
        return $query->where('fk_menu_type_id', 3)->orderBy('menu_order', 'asc');
    }
}
