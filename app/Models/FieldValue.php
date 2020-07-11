<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FieldValue extends Model
{
    //
    protected $fillable = [
        'field_id',
        'display_value',
        'actual_value',
        'forecast_category',
        'module',
    ];

    public function field ()
    {
        return $this->belongsTo('App\Models\Field');
    }
}
