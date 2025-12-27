<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class section extends Model
{
     protected $fillable=[
        "grade_id",
        "name"
    ];

    public  function grade(){
        return $this->belongsTo(grade::class,"grade_id","id");

    }
    public function students(){
        return $this->hasMany(student::class,"section_id","id");
    }
    

}

