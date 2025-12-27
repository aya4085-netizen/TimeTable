<?php
namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\grade;
use App\Models\section;
use Illuminate\Http\Request;

class sectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $section=section::with("grade")->get();
        return view("Supervisor.section.index",compact("section"));
        
    }
    public function search(Request $request)
{
    $query = section::with('grade');

    if ($request->filled('name')) {
        $query->where('name', 'LIKE', '%' . $request->name . '%');
    }

    if ($request->filled('grade')) {
        $query->whereHas('grade', function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->grade . '%');
        });
    }

    $section = $query->orderBy('created_at', 'desc')->get();

    return view("Supervisor.section.index", compact('section'));
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grade=grade::all();
        return view("Supervisor.section.create",compact("grade"));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input = $request->validate([
        "grade_id" => ["required", "exists:grades,id"],
        "name"     => ["required"],
    ]);
        section::create($input);
        return redirect(route("section.index"))->with("success","تم إضافة بالنجاح");
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        return view("Supervisor.section.details",compact("section"));
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        $grade=grade::all();
        return view("Supervisor.section.edit",compact(["grade","section"]));
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, section $section)
    {
        
    $input = $request->validate([
        "grade_id" => ["required", "exists:grades,id"],
        "name"     => ["required"],
    ]);
        $section->update($input);
        return redirect(route("section.index"))->with("success","تم التعديل");


        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(section $section)
    {
        $section->delete();
        return redirect(route("section.index"))->with("success","تم الحذف");

        
    }
}
