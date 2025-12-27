@extends('layout.app')

@section('title','تفاصيل الفصل')

@section('content')

    <h1 class="main-title">تفاصيل الفصل</h1>

    <div class="card card-soft mb-3">
        <div class="card-body">

            <h5 class="fw-bold mb-3">{{ $section->name }}</h5>

            <p class="mb-1">
                <span class="fw-semibold">رقم الفصل:</span> {{ $section->id }}
            </p>

            <p class="mb-1">
                <span class="fw-semibold">الصف الدراسي:</span> {{ $section->grade->name }}
            </p>

        </div>
    </div>

    <a href="{{ route('section.edit', $section->id) }}"
       class="btn btn-primary-custom">
        <i class="bi bi-pencil-square ms-1"></i> تعديل
    </a>

    <a href="{{ route('section.index') }}" class="btn btn-outline-secondary me-2">
        رجوع
    </a>

@endsection
