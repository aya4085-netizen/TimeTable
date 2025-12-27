<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class studenttransfer extends Model
{
    protected $fillable = [
        'student_id',
        'type',
        'from_grade_id',
        'from_section_id',
        'to_grade_id',
        'to_section_id',
        'year',
        'reason'
    ];

    public function student(){ 
    return $this->belongsTo(Student::class,"student_id","id"); 
}
    public function fromGrade(){ return $this->belongsTo(Grade::class,'from_grade_id',"id"); }
    public function fromSection(){ return $this->belongsTo(Section::class,'from_section_id',"id"); }
    public function toGrade(){ return $this->belongsTo(Grade::class,'to_grade_id',"id"); }
    public function toSection(){ return $this->belongsTo(Section::class,'to_section_id',"id"); }
}
