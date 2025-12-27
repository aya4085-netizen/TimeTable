<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\teacher;
use App\Models\User;
use Collator;
use Illuminate\Http\Request;

class teacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teacher=teacher::with("user")->get();
        return view("Supervisor.teacher.index",compact("teacher"));
    }
    public function search(Request $request)
{
    $query = teacher::with('user');

    if ($request->filled('full_name')) {
        $query->where('full_name', 'LIKE', '%' . $request->full_name . '%');
    }

    if ($request->filled('email')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('email', 'LIKE', '%' . $request->email . '%');
        });
    }

    $teacher = $query->orderBy('created_at', 'desc')->get();

    return view("Supervisor.teacher.index", compact('teacher'));
}


    /**
     * Show the form for creating a new resource.
     */
   

    /**
     * Display the specified resource.
     */
    public function show(teacher $teacher)
    {
        return view("Supervisor.teacher.details",compact("teacher"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(teacher $teacher)
    {
        
        $user=User::all();
        return view("Supervisor.teacher.edit",compact("teacher","user"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, teacher $teacher)
    {
       $input = $request->validate([
    'user_id'    => ['required', 'exists:users,id'],
    'full_name'  => ['required'],
    'phonenumber'=> ['required'],
]);

        $teacher->update($input);
        return redirect(route("teacher.index"))->with("success","updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(teacher $teacher)
    {
        $teacher->delete();
        return redirect(route("teacher.index"))->with("success","deleted successfully");
    }
}
