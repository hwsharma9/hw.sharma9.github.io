<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FrontMenuType extends Model
{
    use HasFactory;

    protected $table = "m_front_menu_types";

    protected $fillable = ['title'];

    /**
     * Get all of the frontMenu for the FrontMenuType
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function frontMenu(): HasMany
    {
        return $this->hasMany(FrontMenu::class, 'fk_menu_type_id', 'id');
    }
}
