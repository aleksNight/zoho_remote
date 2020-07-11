<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Field extends Model
{
    //
    protected $fillable = [
        'exid',
        'api_name',
        'field_label',
        'display_label',
        'module'
    ];

    public function values()
    {
        return $this->hasMany('App\Models\FieldValue');
    }
}
