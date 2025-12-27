<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Timetable;
use App\Models\TimeSession;

class StudentDashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $student = Student::with(['grade','section'])
            ->where('user_id', $user->id)
            ->first();

        if (!$student) {
            return view('Student.dashboard', [
                'student'  => null,
                'timetable'=> null,
                'sessions' => collect(),
                'message'  => 'لا يوجد ملف طالب مربوط بحسابك.'
            ]);
        }

        if (!$student->grade_id || !$student->section_id) {
            return view('Student.dashboard', [
                'student'  => $student,
                'timetable'=> null,
                'sessions' => collect(),
                'message'  => 'الطالب غير مربوط بصف/فصل بعد.'
            ]);
        }

        // ✅ آخر جدول منشور لنفس الصف+الفصل
        $timetable = Timetable::whereNotNull('published_at')
            ->where('grade_id', $student->grade_id)
            ->where('section_id', $student->section_id)
            ->orderByDesc('published_at')
            ->first();

        $sessions = collect();

        if ($timetable) {
            $sessions = TimeSession::with(['subject','teacher'])
                ->where('timetable_id', $timetable->id)
                ->orderBy('day')
                ->orderBy('start_time')
                ->get();
        }

        return view('Student.dashboard', [
            'student'  => $student,
            'timetable'=> $timetable,
            'sessions' => $sessions,
            'message'  => $timetable ? null : 'لا يوجد جدول منشور لفصلك حالياً.'
        ]);
    }
}
