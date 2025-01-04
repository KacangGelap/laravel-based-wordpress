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
        return $this->hasManyThrough(
            Subsubmenu::class,  // Dengan target model ini
            Submenu::class,     // Lewat model ini
            'menu_id',          // dengan pencocokkan id model sekarang (menu) dengan model tunnel (submenu)
            'sub_menu_id'       // dan dicocokkan lagi id model tunnel (submenu) dengan model target (subsubmenu)
        );
    }
}
