<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /* Fillable */
    protected $fillable = [
        'filename', 'url'
    ];
}
