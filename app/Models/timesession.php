<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSession extends Model
{
    protected $table = 'time_sessions';

    protected $fillable = [
        'timetable_id',
        'day',
        'start_time',
        'end_time',
        'subject_id',
        'teacher_id',
        'section_id',
    ];

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'timetable_id','id');
    }
    
public function teacher()
{
    return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
}

public function subject()
{
    return $this->belongsTo(Subject::class, 'subject_id', 'id');
}
public function changeRequests()
{
    return $this->hasMany(ChangeRequest::class, 'time_session_id',"id");
}
}
