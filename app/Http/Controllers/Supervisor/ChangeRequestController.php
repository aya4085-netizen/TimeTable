<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use App\Models\ChangeRequest;
use Illuminate\Http\Request;

class ChangeRequestController extends Controller
{
    public function index(Request $request)
    {
        $q = ChangeRequest::with([
            'teacher.user',
            'session.subject',
            'timetable.grade',
            'timetable.section',
        ])->orderByDesc('id');

        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }

        $requests = $q->get();

        return view('Supervisor.change_requests.index', compact('requests'));
    }

    public function show(ChangeRequest $changeRequest)
    {
        $changeRequest->load([
            'teacher.user',
            'session.subject',
            'timetable.grade',
            'timetable.section',
        ]);

        $dayNames = [
            'sat'=>'السبت','sun'=>'الأحد','mon'=>'الإثنين',
            'tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس'
        ];

        return view('Supervisor.change_requests.show', compact('changeRequest','dayNames'));
    }

    public function approve(Request $request, ChangeRequest $changeRequest)
    {
        $request->validate([
            'response_note' => ['nullable','string'],
        ]);

        if ($changeRequest->status !== 'pending') {
            return back()->with('error', 'الطلب تمت معالجته مسبقاً');
        }

        $changeRequest->update([
            'status'        => 'approved',
            'processed_by'  => auth()->id(),
            'response_note' => $request->response_note,
            'processed_at'  => now(),
        ]);

        return back()->with('success', 'تمت الموافقة على الطلب');
    }

    public function reject(Request $request, ChangeRequest $changeRequest)
    {
        $request->validate([
            'response_note' => ['required','string','min:3'],
        ]);

        if ($changeRequest->status !== 'pending') {
            return back()->with('error', 'الطلب تمت معالجته مسبقاً');
        }

        $changeRequest->update([
            'status'        => 'rejected',
            'processed_by'  => auth()->id(),
            'response_note' => $request->response_note,
            'processed_at'  => now(),
        ]);

        return back()->with('success', 'تم رفض الطلب');
    }
}
