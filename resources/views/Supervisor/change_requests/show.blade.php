@extends('layout.app')

@section('title','عرض طلب تغيير')

@section('content')

<h1 class="main-title">عرض طلب تغيير</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card card-soft mb-3">
    <div class="card-body">
        <div class="fw-semibold mb-2">الطلب رقم: <span class="text-muted">{{ $changeRequest->id }}</span></div>

        <div class="text-muted">
            المعلم: <span class="fw-semibold">{{ $changeRequest->teacher->full_name ?? '-' }}</span><br>
            الحصة: <span class="fw-semibold">{{ $changeRequest->session->subject->name ?? '-' }}</span><br>
            الصف/الفصل: <span class="fw-semibold">{{ $changeRequest->timetable->grade->name ?? '-' }} - {{ $changeRequest->timetable->section->name ?? '-' }}</span> |
            السنة: <span class="fw-semibold">{{ $changeRequest->timetable->year }}</span>
        </div>

        <hr>

        <div class="fw-semibold">السبب:</div>
        <div class="text-muted">{{ $changeRequest->reason }}</div>

        <hr>

        <div class="fw-semibold">المقترح:</div>
        <div class="text-muted">
            اليوم: {{ $changeRequest->requested_day ? ($dayNames[$changeRequest->requested_day] ?? $changeRequest->requested_day) : '—' }}<br>
            الوقت: 
            @if($changeRequest->requested_start_time && $changeRequest->requested_end_time)
                {{ substr($changeRequest->requested_start_time,0,5) }} - {{ substr($changeRequest->requested_end_time,0,5) }}
            @else
                —
            @endif
        </div>
    </div>
</div>

@if($changeRequest->status === 'pending')
<div class="card card-soft">
    <div class="card-body">
        <form method="POST" action="{{ route('change_requests.approve', $changeRequest->id) }}" class="d-inline">
            @csrf
            <input type="text" name="response_note" class="form-control mb-2" placeholder="ملاحظة (اختياري)">
            <button class="btn btn-primary-custom">
                <i class="bi bi-check2-circle ms-1"></i> موافقة
            </button>
        </form>

        <form method="POST" action="{{ route('change_requests.reject', $changeRequest->id) }}" class="d-inline ms-2">
            @csrf
            <input type="text" name="response_note" class="form-control mb-2" placeholder="سبب الرفض (ضروري)">
            <button class="btn btn-outline-secondary">
                <i class="bi bi-x-circle ms-1"></i> رفض
            </button>
        </form>
    </div>
</div>
@else
<div class="card card-soft">
    <div class="card-body">
        الحالة:
        @if($changeRequest->status === 'approved')
            <span class="badge bg-success">مقبول</span>
        @else
            <span class="badge bg-danger">مرفوض</span>
        @endif
        <div class="text-muted mt-2">ملاحظة المشرف: {{ $changeRequest->response_note ?? '—' }}</div>
    </div>
</div>
@endif

<a href="{{ route('change_requests.index') }}" class="btn btn-outline-secondary mt-3">رجوع</a>

@endsection
