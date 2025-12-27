<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class grade extends Model
{
    protected $fillable=[
        "name"
    ];

    public function sections(){
        return $this->hasMany(section::class,"grade_id","id");

    }
    public function students(){
        return $this->hasMany(student::class,"grade_id","id");
    }
    


}

