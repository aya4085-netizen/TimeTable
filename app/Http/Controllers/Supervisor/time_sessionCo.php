<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\Timetable;
use App\Models\TimeSession;
use Illuminate\Http\Request;

class time_sessionCo extends Controller
{
    public function store(Request $request, Timetable $timetable)
    {
        $data = $request->validate([
            'day'        => ['required','in:sat,sun,mon,tue,wed,thu'],
            'time_range' => ['required'], 
            'subject_id' => ['required'],
            'teacher_id' => ['required'],
        ]);

   
        [$start, $end] = array_map('trim', explode('-', $data['time_range']));

        // تعارض داخل نفس الجدول
        $conflictTimetable = TimeSession::where('timetable_id', $timetable->id)
            ->where('day', $data['day'])
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time',   '>', $start);
            })
            ->exists();

        if ($conflictTimetable) {
            return back()->with('error','يوجد تعارض في نفس اليوم والوقت')->withInput();
        }

        // تعارض المعلم (نفس السنة)
        $conflictTeacher = TimeSession::where('teacher_id', $data['teacher_id'])
            ->where('day', $data['day'])
            ->whereHas('timetable', fn($q) => $q->where('year',$timetable->year))
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time',   '>', $start);
            })
            ->exists();

        if ($conflictTeacher) {
            return back()->with('error','المعلم لديه حصة في نفس الوقت')->withInput();
        }

        TimeSession::create([
            'timetable_id' => $timetable->id,
            'section_id'   => $timetable->section_id,
            'day'          => $data['day'],
            'start_time'   => $start,
            'end_time'     => $end,
            'subject_id'   => $data['subject_id'],
            'teacher_id'   => $data['teacher_id'],
        ]);

        return redirect()
            ->route('timetable.show',$timetable->id)
            ->with('success','تمت إضافة الحصة بنجاح');
    }

    public function update(Request $request, Timetable $timetable, TimeSession $session)
    {
        if ($session->timetable_id != $timetable->id) {
            return back()->with('error','عملية غير مسموحة');
        }

        $data = $request->validate([
            'day'        => ['required','in:sat,sun,mon,tue,wed,thu'],
            'time_range' => ['required'],
            'subject_id' => ['required'],
            'teacher_id' => ['required'],
        ]);

        [$start, $end] = array_map('trim', explode('-', $data['time_range']));

        // تعارض داخل نفس الجدول (تجاهل نفس السجل)
        $conflictTimetable = TimeSession::where('timetable_id', $timetable->id)
            ->where('day', $data['day'])
            ->where('id','!=',$session->id)
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time',   '>', $start);
            })
            ->exists();

        if ($conflictTimetable) {
            return back()->with('error','يوجد تعارض في نفس اليوم والوقت')->withInput();
        }

        // تعارض المعلم
        $conflictTeacher = TimeSession::where('teacher_id', $data['teacher_id'])
            ->where('day', $data['day'])
            ->where('id','!=',$session->id)
            ->whereHas('timetable', fn($q) => $q->where('year',$timetable->year))
            ->where(function ($q) use ($start, $end) {
                $q->where('start_time', '<', $end)
                  ->where('end_time',   '>', $start);
            })
            ->exists();

        if ($conflictTeacher) {
            return back()->with('error','المعلم لديه حصة في نفس الوقت')->withInput();
        }

        $session->update([
            'day'        => $data['day'],
            'start_time' => $start,
            'end_time'   => $end,
            'subject_id' => $data['subject_id'],
            'teacher_id' => $data['teacher_id'],
        ]);

        return redirect()->route('timetable.show',parameters: $timetable->id)->with('success','تم تحديث الحصة بنجاح');
    }

    public function destroy(Timetable $timetable, TimeSession $session)
    {
        if ($session->timetable_id != $timetable->id) {
            return back()->with('error','عملية غير مسموحة');
        }

        $session->delete();

        return redirect()->route('timetable.show',$timetable->id)->with('success','تم حذف الحصة');
    }
}
