<?php
namespace App\Http\Controllers\Register;
use App\Http\Controllers\Controller;
use App\Models\grade;
use App\Models\Student;
use App\Models\Section;
use App\Models\studenttransfer;
use Illuminate\Http\Request;

class transferController extends Controller
{
    public function create()
    {
        $students = Student::with(['grade','section'])->orderBy('full_name')->get();
        $sections = Section::with('grade')->orderBy('grade_id')->orderBy('name')->get();

        return view('Registrar.moves.transfer', compact('students','sections'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id'   => ['required','exists:students,id'],
            'to_section_id'=> ['required','exists:sections,id'],
            'reason'       => ['nullable','string','max:500'],
        ]);

        $student = Student::with(['grade','section'])->findOrFail($data['student_id']);
        $toSection = Section::findOrFail($data['to_section_id']);

        // ✅ شرط مهم: نقل داخل نفس الصف فقط
        if ((int)$toSection->grade_id !== (int)$student->grade_id) {
            return back()->with('error','لا يمكن نقل الطالب إلى فصل من صف مختلف.')->withInput();
        }

        // ✅ إذا نفس الفصل الحالي
        if ((int)$student->section_id === (int)$toSection->id) {
            return back()->with('error','الطالب بالفعل في نفس الفصل.')->withInput();
        }

        // نسجل الحركة
        studenttransfer::create([
            'student_id'      => $student->id,
            'type'            => 'نقل',
            'from_grade_id'   => $student->grade_id,
            'from_section_id' => $student->section_id,
            'to_grade_id'     => $student->grade_id, // ثابت
            'to_section_id'   => $toSection->id,
            'year'            => now()->year,
            'reason'          => $data['reason'] ?? null,
            'moved_by'        => auth()->id(),
        ]);

        // نحدّث الطالب
        $student->update([
            'section_id' => $toSection->id,
        ]);

        return redirect()->route('registrar.students.index')
            ->with('success','تم نقل الطالب إلى الفصل الجديد بنجاح');
    }

    // نخليه جاهز، بنعبّيه بعدين


public function createPromote()
{
    $grades   = grade::orderBy('id')->get();
    $sections = Section::with('grade')->orderBy('grade_id')->orderBy('name')->get();

    return view('Registrar.moves.promote', compact('grades','sections'));
}

public function storePromote(Request $request)
{
    $data = $request->validate([
        'from_grade_id'   => ['required','exists:grades,id'],
        'from_section_id' => ['nullable','exists:sections,id'], // ممكن "الكل"
        'to_grade_id'     => ['required','exists:grades,id'],
        'to_section_id'   => ['required','exists:sections,id'],
        'reason'          => ['nullable','string','max:500'],
    ]);

    $toSection = Section::findOrFail($data['to_section_id']);

    // لازم الفصل الجديد تابع للصف الجديد
    if ((int)$toSection->grade_id !== (int)$data['to_grade_id']) {
        return back()->with('error','الفصل المختار لا يتبع الصف المُرحّل إليه.')->withInput();
    }

    // نجيب الطلبة حسب الصف + (اختياري) الفصل
    $studentsQuery = Student::where('grade_id', $data['from_grade_id']);

    if (!empty($data['from_section_id'])) {
        $studentsQuery->where('section_id', $data['from_section_id']);
    }

    $students = $studentsQuery->get();

    if ($students->count() === 0) {
        return back()->with('error','مافيش طلبة على الاختيار هذا.')->withInput();
    }

    // ✅ تنفيذ الترحيل: سجل + تحديث الطلبة
    foreach ($students as $st) {

        studenttransfer::create([
            'student_id'      => $st->id,
            'type'            => 'ترحيل',
            'from_grade_id'   => $st->grade_id,
            'from_section_id' => $st->section_id,
            'to_grade_id'     => $data['to_grade_id'],
            'to_section_id'   => $toSection->id,
            'year'            => now()->year,
            'reason'          => $data['reason'] ?? null,
            'moved_by'        => auth()->id(),
        ]);

        $st->update([
            'grade_id'   => $data['to_grade_id'],
            'section_id' => $toSection->id,
        ]);
    }

    return redirect()->route('registrar.students.index')
        ->with('success','تم ترحيل عدد ('.$students->count().') طالب بنجاح');
}
}
