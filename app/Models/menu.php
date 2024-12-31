<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    public function subMenus()
    {
        return $this->hasMany(Submenu::class, 'menu_id');
    }

    public function subSubMenus()
    {
        // Use the correct foreign keys and model names
        return $this->hasManyThrough(
            Subsubmenu::class,  // Target model
            Submenu::class,     // Intermediate model
            'menu_id',          // Foreign key on Submenu
            'sub_menu_id'       // Foreign key on Subsubmenu
        );
    }
}
