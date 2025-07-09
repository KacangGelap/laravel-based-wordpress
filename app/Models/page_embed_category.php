<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class page_embed_category extends Model
{
    use HasFactory;
    protected $table = 'page_embed_category';
    protected $fillable = ['kategori'];
    public function embeds(){
        return $this->hasMany(page_embed::class, 'kategori_id');
    }
}
