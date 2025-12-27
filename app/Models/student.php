<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $fillable=[
        "user_id",
        "full_name",
        "grade_id",
        "section_id",
        "date_of_birth"
    ];

    public function user(){
        return $this->belongsTo(User::class,"user_id","id");
    }
    public function grade(){
        return $this->belongsTo(grade::class,"grade_id","id");

    }
    public function section(){
        return $this->belongsTo(section::class,"section_id","id");
    }
    
}
