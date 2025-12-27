<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Timetable;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $student = Student::where('user_id', $user->id)->first();

        if (!$student) {
            return view('Student.dashboard', [
                'timetable' => null,
                'message' => 'لا يوجد ملف طالب مربوط بحسابك.'
            ]);
        }

        if (!$student->grade_id || !$student->section_id) {
            return view('Student.dashboard', [
                'timetable' => null,
                'message' => 'الطالب غير مربوط بصف/فصل بعد.'
            ]);
        }

        $timetable = Timetable::whereNotNull('published_at')
            ->where('year', date('Y'))
            ->where('grade_id', $student->grade_id)
            ->where('section_id', $student->section_id)
            ->first();

        return view('Student.dashboard', [
            'timetable' => $timetable,
            'message' => $timetable ? null : 'لا يوجد جدول منشور لفصلك حالياً.'
        ]);
    }
}
