<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class layout extends Model
{
    use HasFactory;

    protected $table = 'layout';

    protected $fillable = [
        'media',
        'type'
    ];
}
