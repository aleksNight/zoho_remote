<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connect extends Model
{
    //
    protected $fillable = ['client_id', 'secret', 'refresh_token', 'user_id', 'active', 'description'];
}
