<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subsubmenu extends Model
{
    use HasFactory;
    protected $table = 'sub_sub_menus';
    protected $fillable = ['sub_menu_id', 'sub_sub_menu', 'filetype', 'media'];

    public function subMenu()
    {
        return $this->belongsTo(submenu::class, 'sub_menu_id');
    }
}
