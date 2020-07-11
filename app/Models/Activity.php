<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    //
    protected $fillable = [
        'exid',
        'description',
        'type',
        'created',
        'closed',
        'subject',
        'module',
        'status',
        'priority',
        'owner_exid',
//        'owner_email',
        'contact_exid',
//        'who_name',
        'record_exid',
//        'what_name',
        'user_id',
        'record_id',
        'contact_id'
    ];
    public function user ()
    {
        $this->belongsTo('App\Models\User');
    }

    public function contact ()
    {
        $this->belongsTo('App\Models\Contact');
    }

    public function deal ()
    {
        $this->belongsTo('App\Models\Deal');
    }
}
