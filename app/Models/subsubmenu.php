<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsubmenu extends Model
{
    use HasFactory;
    protected $table = 'sub_sub_menus';
    protected $fillable = [
        'sub_menu_id',
        'sub_sub_menu',
        'type',
        'filetype',
        'media',
        'yt_id',
        'link',
        'alamat',
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

    public function subSubSubMenus(){
        return $this->hasMany(subsubsubmenu::class, 'sub_sub_menu_id');
    }
    public function subMenu()
    {
        return $this->belongsTo(submenu::class, 'sub_menu_id');
    }
}
