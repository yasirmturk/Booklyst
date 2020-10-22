<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Castable;
use Illuminate\Database\Eloquent\Model;

class Image extends Model //implements Castable
{
    /* Fillable */
    protected $fillable = [
        'filename', 'url'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'id', 'url', 'created_at', 'updated_at', 'pivot',
    ];

    /**
     * Get the owning imageable model.
     */
    public function imageable()
    {
        return $this->morphTo();
    }

    // /**
    //  * Get the name of the caster class to use when casting from / to this cast target.
    //  *
    //  * @return string
    //  */
    // public static function castUsing()
    // {
    //     return ImageCast::class;
    // }
}
