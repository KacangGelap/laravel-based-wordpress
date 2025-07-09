<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class advanced_carousel extends Model
{
    use HasFactory;
    protected $table = 'advanced_carousel';
    protected $fillable = [
        'kategori_id',
        'judul',
        'media'
    ];
    public function category(){
        return $this->belongsTo(advanced_carousel_category::class, 'kategori_id');
    }
}
