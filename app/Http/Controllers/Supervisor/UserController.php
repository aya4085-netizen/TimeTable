<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // المشرف يشوف الحسابات اللي ينشئها (عدّلي حسب رغبتك)
        $users = User::orderBy('id')->get();

        return view('Supervisor.users.index', compact('users'));
    }

    public function create()
    {
        $roles = [
            'teacher'   => 'معلم',
            'registrar' => 'موظف شؤون الطلبة',
            'supervisor'=> 'مشرف',
        ];

        return view('Supervisor.users.create', compact('roles'));
    }



public function store(Request $request)
{
    $data = $request->validate([
        'name'                  => ['required','string','max:255'],
        'email'                 => ['required','email','max:255','unique:users,email'],
        'role'                  => ['required','in:teacher,student,registrar,supervisor'],
        'password'              => ['required','min:6','confirmed'],
    ]);

    $user = User::create([
        'name'     => $data['name'],
        'email'    => $data['email'],
        'role'     => $data['role'],
        'password' => Hash::make($data['password']),
    ]);


    if ($data['role'] === 'teacher') {
        teacher::create([
            'user_id'   => $user->id,
            'full_name' => $data['name'],
        ]);
    }

    // if ($data['role'] === 'student') {
    //     Student::create([
    //         'user_id'   => $user->id,
    //         'full_name' => $data['name'],
    //     ]);
    // }

    return redirect()->route('supervisor.users.index')->with('success', 'تم إنشاء الحساب وربطه بنجاح');
}

    public function destroy(User $user)
    {

        if (auth()->id() === $user->id) {
            return back()->with('error','لا يمكنك حذف حسابك الحالي');
        }

        $user->delete();
        return back()->with('success','تم حذف الحساب');
    }
}
