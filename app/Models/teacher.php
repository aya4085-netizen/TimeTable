<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
     protected $fillable=[
        "user_id",
        "full_name",
        "phonenumber"
     ];

     public function user(){
        return $this->belongsTo(User::class,"user_id","id");
     }
     
public function sessions()
{
    return $this->hasMany(TimeSession::class,'teacher_id',"id");
}
public function changeRequests()
{
    return $this->hasMany(ChangeRequest::class, 'teacher_id',"id");
}

}

