<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsubsubmenu extends Model
{
    use HasFactory;
    protected $table = 'sub_sub_sub_menus';
    protected $fillable = [
        'sub_sub_menu_id',
        'sub_sub_sub_menu',
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
    public function subSubSubSubMenus(){
        return $this->hasMany(subsubsubsubmenu::class, 'sub_sub_sub_menu_id');
    }
    public function halaman(){
        return $this->hasMany(halaman::class, 'sub_sub_sub_menu_id');
    }
    public function subSubMenu()
    {
        return $this->belongsTo(subsubmenu::class, 'sub_sub_menu_id');
    }
}
