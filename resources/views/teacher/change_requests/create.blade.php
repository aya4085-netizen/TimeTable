@extends('layout.app')

@section('title','طلب تغيير حصة')

@section('content')

@php
    $dayNames = [
        'sat' => 'السبت',
        'sun' => 'الأحد',
        'mon' => 'الإثنين',
        'tue' => 'الثلاثاء',
        'wed' => 'الأربعاء',
        'thu' => 'الخميس',
    ];

    $currentDay = $dayNames[$session->day] ?? $session->day;
@endphp

<h1 class="main-title">طلب تغيير حصة</h1>

<div class="card card-soft mb-3">
    <div class="card-body">
        <div class="fw-semibold mb-2">تفاصيل الحصة:</div>
        <div class="text-muted">
            المادة: <span class="fw-semibold">{{ $session->subject->name ?? '-' }}</span> |
            اليوم: <span class="fw-semibold">{{ $currentDay }}</span> |
            الوقت: <span class="fw-semibold">{{ substr($session->start_time,0,5) }} - {{ substr($session->end_time,0,5) }}</span><br>
            الصف/الفصل: <span class="fw-semibold">{{ $session->timetable->grade->name ?? '-' }} - {{ $session->timetable->section->name ?? '-' }}</span> |
            السنة: <span class="fw-semibold">{{ $session->timetable->year }}</span>
        </div>
    </div>
</div>

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<form method="POST" action="{{ route('teacher.change_requests.store', $session->id) }}">
    @csrf

    <div class="card card-soft">
        <div class="card-body">
            <div class="row g-3">

                <div class="col-12">
                    <label class="form-label">سبب طلب التغيير</label>
                    <textarea name="reason" rows="4"
                              class="form-control @error('reason') is-invalid @enderror"
                              placeholder="مثال: عندي التزام، أو يوجد تعارض...">{{ old('reason') }}</textarea>
                    @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">اليوم المقترح (اختياري)</label>
                    <select name="requested_day" class="form-select @error('requested_day') is-invalid @enderror">
                        <option value="">بدون تغيير</option>
                        @foreach($days as $d)
                            <option value="{{ $d }}" {{ old('requested_day') == $d ? 'selected' : '' }}>
                                {{ $dayNames[$d] ?? $d }}
                            </option>
                        @endforeach
                    </select>
                    @error('requested_day') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">الوقت المقترح (اختياري)</label>
                    <select name="time_range" class="form-select @error('time_range') is-invalid @enderror">
                        <option value="">بدون تغيير</option>
                        @foreach($timeRows as $tr)
                            <option value="{{ $tr }}" {{ old('time_range') == $tr ? 'selected' : '' }}>
                                {{ $tr }}
                            </option>
                        @endforeach
                    </select>
                    @error('time_range') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="col-12 d-flex gap-2 mt-2">
                    <button class="btn btn-primary-custom">
                        <i class="bi bi-send ms-1"></i> إرسال الطلب
                    </button>

                    <a href="{{ route('teacher.timetable') }}" class="btn btn-outline-secondary">
                        رجوع
                    </a>
                </div>

            </div>
        </div>
    </div>
</form>

@endsection
