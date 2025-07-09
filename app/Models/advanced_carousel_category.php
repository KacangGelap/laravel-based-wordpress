<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class advanced_carousel_category extends Model
{
    use HasFactory;
    protected $table = 'advanced_carousel_category';
    protected $fillable = ['kategori'];
    public function carousels(){
        return $this->hasMany(advanced_carousel::class, 'kategori_id');
    }
}
