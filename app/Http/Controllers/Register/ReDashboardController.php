<?php

namespace App\Http\Controllers\Register;

use App\Http\Controllers\Controller;
use App\Models\student;
use Illuminate\Http\Request;

class ReDashboardController extends Controller
{
     public function index()
    {
        $studentsCount = student::count();
        return view('registrar.dashboard', compact('studentsCount'));
    }
}
