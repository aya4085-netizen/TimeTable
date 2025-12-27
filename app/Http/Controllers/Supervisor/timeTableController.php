<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\section;
use App\Models\time_sessions;
use App\Models\Time_slots;
use App\Models\timetable;
use App\Models\grade;
use App\Models\timeSlot;
use App\Models\subject;
use App\Models\teacher;
use App\Models\TimeSession;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class timeTableController extends Controller
{
    /**
     * عرض جميع الجداول الدراسية
     */
    public function index()
    {
        $timetables = timetable::with(['grade', 'section'])
            ->orderByDesc('year')
            ->orderBy('grade_id')
            ->orderBy('section_id')
            ->get();

        return view('Supervisor.timetable.index', compact('timetables'));
    }
    public function search(Request $request)
{
    $query = timetable::with(['grade','section']);

    if ($request->filled('year')) {
        $query->where('year', $request->year);
    }

    if ($request->filled('grade')) {
        $query->whereHas('grade', function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->grade . '%');
        });
    }

    if ($request->filled('section')) {
        $query->whereHas('section', function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->section . '%');
        });
    }

    $timetables = $query->orderBy('year','desc')->get();

    return view('Supervisor.timetable.index', compact('timetables'));
}


    /**
     * فورم إنشاء جدول جديد (لصف + فصل + سنة)
     */
    public function create()
    {
        $grades   = grade::all();
        $sections = section::all(); // ممكن لاحقًا تصفيها بالـ JS حسب الصف

        return view('Supervisor.timetable.create', compact('grades', 'sections'));
    }

    /**
     * حفظ جدول جديد
     */
    public function store(Request $request)
    {
        
        $data = $request->validate([
            'grade_id'   => ['required', 'exists:grades,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'year'       => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
                // منع تكرار جدول لنفس (الصف + الفصل + السنة)
                Rule::unique('timetables')->where(function ($q) use ($request) {
                    return $q->where('grade_id', $request->grade_id)
                             ->where('section_id', $request->section_id);
                }),
            ],
        ]);

        $timetable = timetable::create($data);

        return redirect()
            ->route('timetable.show', $timetable->id)
            ->with('success', 'تم إنشاء الجدول الدراسي بنجاح.');
    }

public function show(Timetable $timetable)
{
    $timetable->load(['grade','section']);

  $sessions = TimeSession::with(['subject','teacher'])
    ->where('timetable_id', $timetable->id)
    ->orderBy('day')
    ->orderBy('start_time')
    ->get();


    $subjects = Subject::all();
    $teachers = Teacher::all();

    return view('Supervisor.timetable.show', compact(
        'timetable',
        'sessions',
        'subjects',
        'teachers'
    ));
}



    /**
     * تعديل بيانات الجدول (الصف + الفصل + السنة)
     */
    public function edit(timetable $timetable)
    {
        $grades   = grade::all();
        $sections = section::all();

        return view('Supervisor.timetable.edit', compact('timetable', 'grades', 'sections'));
    }

    /**
     * حفظ تعديل الجدول
     */
    public function update(Request $request, timetable $timetable)
    {
        $data = $request->validate([
            'grade_id'   => ['required', 'exists:grades,id'],
            'section_id' => ['required', 'exists:sections,id'],
            'year'       => [
                'required',
                'integer',
                'min:2000',
                'max:2100',
                Rule::unique('timetables')
                    ->ignore($timetable->id)
                    ->where(function ($q) use ($request) {
                        return $q->where('grade_id', $request->grade_id)
                                 ->where('section_id', $request->section_id);
                    }),
            ],
        ]);

        $timetable->update($data);

        return redirect()
            ->route('timetable.index')
            ->with('success', 'تم تحديث بيانات الجدول بنجاح.');
    }

    /**
     * حذف جدول (ومعه الحصص التابعة له بسبب cascadeOnDelete)
     */
    public function destroy(timetable $timetable)
    {
        $timetable->delete();

        return redirect()
            ->route('timetable.index')
            ->with('success', 'تم حذف الجدول الدراسي بنجاح.');
    }
    public function publish(timetable $timetable)
{
    $timetable->update([
        'published_at' => now(),
    ]);

    return back()->with('success', 'تم نشر الجدول للطلاب والمعلمين');
}

public function unpublish(timetable $timetable)
{
    $timetable->update([
        'published_at' => null,
    ]);

    return back()->with('success', 'تم إلغاء نشر الجدول');
}
}
