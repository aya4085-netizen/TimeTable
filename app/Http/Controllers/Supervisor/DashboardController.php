<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Supervisor.dashboard', [
            'usersCount'    => User::count(),
            'teachersCount' => teacher::count(),
            'subjectsCount' => subject::count(),
            'gradesCount'   => grade::count(),
            'sectionsCount' => section::count(),
        ]);
    }
}
