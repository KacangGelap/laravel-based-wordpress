<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class page_embed extends Model
{
    use HasFactory;
    protected $table = 'page_embed';
    protected $fillable = [
        'kategori_id',
        'link'
    ];
    public function category(){
        return $this->belongsTo(page_embed_category::class, 'kategori_id');
    }
}
