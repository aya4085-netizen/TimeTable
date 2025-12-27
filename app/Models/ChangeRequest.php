<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChangeRequest extends Model
{
    protected $table = 'change_requests';

    protected $fillable = [
        'time_session_id',
        'teacher_id',
        'timetable_id',
        'requested_day',
        'requested_start_time',
        'requested_end_time',
        'reason',
        'status',
        'processed_by',
        'response_note',
        'processed_at',
    ];

    public function session()
    {
        return $this->belongsTo(TimeSession::class, 'time_session_id',"id");
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id',"id");
    }

    public function timetable()
    {
        return $this->belongsTo(Timetable::class, 'timetable_id',"id");
    }

    public function processor()
    {
        return $this->belongsTo(User::class, 'processed_by',"id");
    }
}
