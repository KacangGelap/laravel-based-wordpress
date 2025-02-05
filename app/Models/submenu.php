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
        'tambahan1',
        'tambahan2',
        'tambahan3',
        'yt_id',
        'link',
        'alamat',
        'telp',
        'wa',
        'fax',
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
    public function halaman()
    {
        return $this->hasMany(halaman::class, 'sub_menu_id');
    }
    public function menu()
    {
        return $this->belongsTo(menu::class, 'menu_id');
    }
}
