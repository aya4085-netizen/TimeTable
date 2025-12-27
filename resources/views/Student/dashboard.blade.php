@extends('layout.auth')

@section('title','لوحة الطالب')

@section('content')
<div class="container" style="max-width:900px;">
    <h3 class="mb-3">لوحة الطالب</h3>

    @if($message)
        <div class="alert alert-warning">{{ $message }}</div>
    @endif

    @if($timetable)
        <div class="card card-soft">
            <div class="card-body">
                <div class="fw-semibold mb-2">
                    يوجد جدول منشور للسنة: {{ $timetable->year }}
                </div>

                <a href="{{ route('timetable.show', $timetable->id) }}" class="btn btn-primary-custom">
                    فتح الجدول
                </a>
            </div>
        </div>
    @endif
</div>
@endsection
