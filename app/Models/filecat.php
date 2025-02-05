<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class filecat extends Model
{
    use HasFactory;
    protected $table = 'filecat';
    protected $fillable = [
        'cat'
    ];

    public function unduh(){
        return $this->hasMany(unduh::class, 'filecat_id');
    }
}
