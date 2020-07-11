<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    //
    protected $fillable = [
        'exid',
        'First_Name',
        'Last_Name',
        'Email',
        'Lead_Source',
        'Mailing_Country',
        'Department',
        'Mailing_Zip',
        'Twitter',
        'Mailing_Street',
        'Skype_ID',
        'Phone',
        'Mailing_City',
        'Title',
        'Mobile',
    ];

    public function activity ()
    {
        //
        $this->hasMany('App\Models\Activity');
    }

    public function deal ()
    {
        //
        $this->hasMany('App\Models\Deal');
    }

}
