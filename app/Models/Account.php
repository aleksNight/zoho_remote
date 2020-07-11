<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //
    protected $fillable = [
        'exid',
        'Annual_Revenue',
        'Employees',
        'Ownership',
        'Description',
        'Account_Name',
        'Account_Type',
        'Website',
        'Industry',
        'Phone',
        'Billing_Country',
        'Billing_Street',
        'Billing_Code',
        'Billing_City',
        'Billing_State',
    ];

    public function deal ()
    {
        //
        $this->hasMany('App\Models\Deal');
    }

}
