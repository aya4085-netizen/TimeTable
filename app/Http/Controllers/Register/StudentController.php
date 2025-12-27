<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\grade;
use App\Models\section;
use App\Models\student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    
    public function index(Request $request)
{
    $query = student::with(['user','grade','section']);

    // بحث بالاسم أو الإيميل
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where('full_name', 'LIKE', "%{$search}%")
              ->orWhereHas('user', function ($q) use ($search) {
                  $q->where('email', 'LIKE', "%{$search}%");
              });
    }

    // فلتر الصف
    if ($request->filled('grade_id')) {
        $query->where('grade_id', $request->grade_id);
    }

    // فلتر الفصل
    if ($request->filled('section_id')) {
        $query->where('section_id', $request->section_id);
    }

    $students = $query->orderByDesc('id')->paginate(10)->withQueryString();

    $grades = grade::orderBy('id')->get();
    $sections = section::with('grade')->orderBy('id')->get();

    return view("Registrar.students.index", compact("students","grades","sections"));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user=User::all();
        $grade=grade::all();
        $section=section::all();
        return view("Registrar.students.create",compact(["user","grade","section"]));
    }

    /**
     * Store a newly created resource in storage.
     */

public function store(Request $request)
{
    $data = $request->validate([
        'email'        => ['required','email','max:255', Rule::unique('users','email')],
        'password'     => ['required','min:6','confirmed'],

        'full_name'    => ['required','string','max:255'],
        'grade_id'     => ['required','exists:grades,id'],
        'section_id'   => ['required','exists:sections,id'],
        'date_of_birth'=> ['required','date'],
    ]);

    // 1) create user
    $user = User::create([
        'name'     => $data['full_name'],
        'email'    => $data['email'],
        'role'     => 'student',
        'password' => Hash::make($data['password']),
    ]);

    // 2) create student linked to user
    Student::create([
        'user_id'      => $user->id,
        'full_name'    => $data['full_name'],
        'grade_id'     => $data['grade_id'],
        'section_id'   => $data['section_id'],
        'date_of_birth'=> $data['date_of_birth'],
    ]);

    return redirect()->route('registrar.students.index')
        ->with('success','تم إنشاء حساب الطالب وإضافته بنجاح');
}

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        return view("Registrar.students.show",compact("student"));

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student $student)
    {
        $user=User::all();
        $grade=grade::all();
        $section=section::all();
        return view("Registrar.students.edit",compact(["student","user","grade","section"]));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $student)
{
    $data = $request->validate([
        'full_name'     => ['required','string','max:255'],
        'grade_id'      => ['required','exists:grades,id'],
        'section_id'    => ['required','exists:sections,id'],
        'date_of_birth' => ['required','date'],
    ]);

    $student->update($data);

    return redirect()->route('registrar.students.index')
        ->with('success','تم تحديث بيانات الطالب بنجاح');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student $student)
    {
        $student->delete();
      return redirect()->route('registrar.students.index')
        ->with('success','تم الحذف بيانات الطالب بنجاح');
    }
}
