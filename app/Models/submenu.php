<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class submenu extends Model
{
    use HasFactory;
    protected $table = 'sub_menus';
    protected $fillable = [
        'menu_id',
        'sub_menu',
        'type',
        'filetype',
        'media',
        'yt_id',
        'link',
        'alamat',
        'maps',
        'telp',
        'email',
        'website',
        'instagram',
        'facebook',
        'youtube',
        'tiktok',
        'x',
        'maps',
        'text'
    ];

    public function subSubMenus()
    {
        return $this->hasMany(subsubmenu::class, 'sub_menu_id');
    }

    public function menu()
    {
        return $this->belongsTo(menu::class, 'menu_id');
    }
}
