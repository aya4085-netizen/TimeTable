<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\subject;
use Illuminate\Http\Request;

class subjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $subject = subject::all();    
    return view('Supervisor.subject.index', compact('subject'));
}
public function search(Request $request)
{
    $query = subject::query();

    if ($request->filled('name')) {
        $query->where('name', 'LIKE', '%' . $request->name . '%');
    }

    $subject = $query->orderBy('created_at', 'desc')->get();

    return view('Supervisor.subject.index', compact('subject'));
}



    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("Supervisor.subject.create");
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $input=$request->validate([
            "name"=>["required"],
            "weekly_limit"=>["required"]
        ]);
        subject::create($input);
        return redirect(route("subject.index"))->with("success","added successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(subject $subject)
    {
        return view("Supervisor.subject.details",compact("subject"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(subject $subject)
    {
        return view("Supervisor.subject.edit",compact("subject"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, subject $subject)
    {
        $input=$request->validate([
            "name"=>["required"],
            "weekly_limit"=>["required"]
        ]);
        $subject->update($input);
        return redirect(route("subject.index"))->with("success","updated successfully");

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(subject $subject)
    {
        $subject->delete();
        return redirect(route("subject.index"))->with("success","deleted successfully");

    }
}
