<?php
namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\grade;
use Illuminate\Http\Request;

class gradeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grade=grade::all();
        return view("Supervisor.grade.index",compact('grade'));
        
    }
    public function search(Request $request)
{
    $query = grade::query();

    if ($request->filled('name')) {
        $query->where('name', 'LIKE', '%' . $request->name . '%');
    }

    $grade = $query->orderBy('created_at', 'desc')->get();

    return view("Supervisor.grade.index", compact('grade'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Supervisor.grade.create");
 

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->validate([
            "name"=>["required"]
        ]);
        grade::create($input);
        return redirect(route("grade.index"))->with("success","تم إضافة بالنجاح");
    }

    /**
     * Display the specified resource.
     */
    public function show(grade $grade)
    {
        return view("Supervisor.grade.details",compact('grade'));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(grade $grade)
    {
        return view("Supervisor.grade.edit",compact('grade'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, grade $grade)
    {
        $input=$request->validate([
            "name"=>["required"]
        ]);
        $grade->update($input);
        return redirect(route("grade.index"))->with("success"," تم التعديل");

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy( grade $grade)
    {
        $grade->delete();
        return redirect(route("grade.index"))->with("success","تم الحذف");

    }
}
