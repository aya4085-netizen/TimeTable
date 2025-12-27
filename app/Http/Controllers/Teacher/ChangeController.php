<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use App\Models\Teacher;
use App\Models\TimeSession;
use Illuminate\Http\Request;

class ChangeController extends Controller
{
    public function create(TimeSession $session)
    {
        $user = auth()->user();

        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        // حماية: لازم الحصة تخص نفس المعلم
        if ((int)$session->teacher_id !== (int)$teacher->id) {
            abort(403, 'غير مسموح');
        }

        $session->load(['subject','timetable.grade','timetable.section']);

        $days = ['sat','sun','mon','tue','wed','thu'];
        $dayNames = [
            'sat'=>'السبت','sun'=>'الأحد','mon'=>'الإثنين',
            'tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس'
        ];

        $timeRows = collect([
            '08:00 - 08:45',
            '08:45 - 09:30',
            '09:30 - 10:15',
            '10:15 - 11:00',
            '11:00 - 11:45',
            '11:45 - 12:30',
        ]);

        return view('Teacher.change_requests.create', compact(
            'session','teacher','days','dayNames','timeRows'
        ));
    }

    public function store(Request $request, TimeSession $session)
    {
        $user = auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        if ((int)$session->teacher_id !== (int)$teacher->id) {
            abort(403, 'غير مسموح');
        }

        $data = $request->validate([
            'reason'        => ['required','string','min:5'],
            'requested_day' => ['nullable','in:sat,sun,mon,tue,wed,thu'],
            'time_range'    => ['nullable','string'], // "08:00 - 08:45"
        ]);

        $start = null;
        $end   = null;

        if (!empty($data['time_range'])) {
            [$start, $end] = array_map('trim', explode('-', $data['time_range']));
        }

        ChangeRequest::create([
            'time_session_id'       => $session->id,
            'teacher_id'            => $teacher->id,
            'timetable_id'          => $session->timetable_id,
            'requested_day'         => $data['requested_day'] ?? null,
            'requested_start_time'  => $start,
            'requested_end_time'    => $end,
            'reason'                => $data['reason'],
            'status'                => 'pending',
        ]);

        return redirect()->route('teacher.timetable')->with('success', 'تم إرسال طلب التغيير للمشرف');
    }

    public function index()
    {
        $user = auth()->user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();

        $requests = ChangeRequest::with(['session.subject','timetable.grade','timetable.section'])
            ->where('teacher_id', $teacher->id)
            ->orderByDesc('id')
            ->get();

        return view('Teacher.change_requests.index', compact('teacher','requests'));
    }
    public function destroy($id)
{
    $teacher = Teacher::where('user_id', auth()->id())->firstOrFail();

    $req = ChangeRequest::where('id', $id)
        ->where('teacher_id', $teacher->id)
        ->firstOrFail();

    if ($req->status !== 'pending') {
        return back()->with('error', 'لا يمكن حذف طلب تم الرد عليه.');
    }

    $req->delete();

    return back()->with('success', 'تم حذف الطلب بنجاح.');
}

}
