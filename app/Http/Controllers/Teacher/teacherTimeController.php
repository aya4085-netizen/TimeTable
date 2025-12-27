<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TimeSession;
use Illuminate\Http\Request;

class TeacherTimeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // نجيب سجل المعلم المرتبط بحساب المستخدم
        $teacher = Teacher::where('user_id', $user->id)->first();

        if (!$teacher) {
            return redirect()->route('redirect')->with('error', 'هذا الحساب غير مربوط بسجل معلم.');
        }

        // ✅ نجيب حصص المعلم لكن فقط الجداول "المنشورة"
        $sessions = TimeSession::with([
                'subject',
                'timetable.grade',
                'timetable.section',
            ])
            ->where('teacher_id', $teacher->id)
            ->whereHas('timetable', function ($q) {
                $q->whereNotNull('published_at');
            })
            ->orderBy('day')
            ->orderBy('start_time')
            ->get();

        return view('Teacher.index', compact('teacher', 'sessions'));
    }
}
