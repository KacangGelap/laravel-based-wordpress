<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unduh extends Model
{
    use HasFactory;
    protected $table = 'unduh';
    protected $fillable = [
        'nama',
        'media',
        'filecat_id'
    ];

    public function filecat(){
        return $this->belongsTo(filecat::class, 'filecat_id');
    }
}
