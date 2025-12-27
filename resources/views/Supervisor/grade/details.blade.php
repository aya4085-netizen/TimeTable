@extends('layout.app')

@section('title','تفاصيل الصف')

@section('content')

    <h1 class="main-title">تفاصيل الصف</h1>

    <div class="card card-soft mb-3">
        <div class="card-body">
            <h5 class="mb-3">{{ $grade->name }}</h5>

            <p class="mb-1">
                <span class="fw-semibold">رقم الصف (ID):</span>
                {{ $grade->id }}
            </p>

            {{-- لو فيما بعد ربطته بعدد الطلاب أو الفصول الفرعية تقدر تضيف هنا --}}
        </div>
    </div>

    <a href="{{ route('grade.edit', $grade->id) }}" class="btn btn-primary-custom">
        <i class="bi bi-pencil-square ms-1"></i> تعديل
    </a>
    <a href="{{ route('grade.index') }}" class="btn btn-outline-secondary me-2">
        رجوع إلى قائمة الصفوف
    </a>

@endsection
