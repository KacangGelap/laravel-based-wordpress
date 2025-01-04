<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;
    
    protected $table = 'post';

    protected $fillable = [
        'judul',
        'media1',
        'media2',
        'media3',
        'media4',
        'deskripsi',
        'contributor',
        'kategori_id',
        'user_id',

    ];
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
    public function kategori(){
        return $this->belongsTo('App\Models\kategori');
    }
}
