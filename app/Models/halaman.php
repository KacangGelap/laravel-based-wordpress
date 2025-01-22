<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class halaman extends Model
{
    use HasFactory;
    protected $table = 'halaman';

    protected $fillable = [
        'menu_id',
        'sub_menu_id',
        'sub_sub_menu_id',
        'sub_sub_sub_menu_id',
    ];
    public function menu(){
        return $this->belongsTo(menu::class, 'menu_id');
    }
    public function submenu(){
        return $this->belongsTo(submenu::class, 'sub_menu_id');
    }
    public function subsubmenu(){
        return $this->belongsTo(subsubmenu::class, 'sub_sub_menu_id');
    }
    public function subsubsubmenu(){
        return $this->belongsTo(subsubsubmenu::class, 'sub_sub_sub_menu_id');
    }
}
