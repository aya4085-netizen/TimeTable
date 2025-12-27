<?php

namespace App\Http\Controllers;

use App\Models\grade;
use App\Models\section;
use App\Models\student;
use App\Models\User;
use Illuminate\Http\Request;

class studnetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $student=student::with("user","grade","section")->get();
        return view("",compact("student"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user=User::all();
        $grade=grade::all();
        $section=section::all();
        return view("",compact(["user","grade","section"]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->validate([
        "user_id"=>["required|exists:users,id"],
        "full_name"=>["required"],
        "grade_id"=>["required|exists:grades,id"],
        "section_id"=>["required|exists:sections,id"],
        "date_of_birth"=>["required","date"],
        ]);
        student::create($input);
        return redirect(route(""))->with("success","added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        return view("",compact("student"));

        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student $student)
    {
        $user=User::all();
        $grade=grade::all();
        $section=section::all();
        return view("",compact(["student","user","grade","section"]));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $student)
    {
        $input=$request->validate([
        "user_id"=>["required|exists:users,id"],
        "full_name"=>["required"],
        "grade_id"=>["required|exists:grades,id"],
        "section_id"=>["required|exists:sections,id"],
        "date_of_birth"=>["required","date"],
        ]);
        $student->update($input);
        return redirect(route(""))->with("success","updated successfully");

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student $student)
    {
        $student->delete();
        return redirect(route(""))->with("success","deleted successfully");

    }
}
