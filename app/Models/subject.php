<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    protected $fillable=[
        "name",
        "weekly_limit"
    ];
}
