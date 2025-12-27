<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class timetable extends Model
{
    protected $table = 'timetables';

    protected $fillable = [
        'grade_id',
        'section_id',
        'year',
        'published_at', // ✅ مهم للنشر
    ];

    protected $casts = [
        'published_at' => 'datetime', // ✅ عشان يتعامل كتاريخ
    ];

    public function grade()
    {
        return $this->belongsTo(grade::class, 'grade_id', 'id');
    }

    public function section()
    {
        return $this->belongsTo(section::class, 'section_id', 'id');
    }

    public function sessions()
    {
        return $this->hasMany(TimeSession::class, 'timetable_id',"id");
    }
}
