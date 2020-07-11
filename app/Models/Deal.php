<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    //
    protected $fillable = [
        'Deal_Name',
        'Stage',
        'Type',
        'Lead_Source',
        'Description',
        'Owner_exid',
        'Account_exid',
        'Contact_exid',
        'Expected_Revenue',
        'Amount',
        'Probability',
        'user_id',
        'contact_id',
        'account_id',
        'exid',
    ];

    public function activity ()
    {
        $this->hasMany('App\Models\Activity');
    }

    public function user ()
    {
        $this->belongsTo('App\Models\User');
    }

    public function contact ()
    {
        $this->belongsTo('App\Models\Contact');
    }

    public function account ()
    {
        $this->belongsTo('App\Models\Account');
    }

}
