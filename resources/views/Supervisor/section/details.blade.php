@extends('layout.app')

@section('title','تفاصيل الفصل')

@section('content')

<h1 class="main-title mb-3">تفاصيل الفصل</h1>

<div class="card card-soft">
    <div class="card-body">

        <h5 class="fw-bold mb-3">{{ $section->name }}</h5>

        <div class="mb-2">
            <span class="fw-semibold">رقم الفصل:</span>
            <span class="text-muted">{{ $section->id }}</span>
        </div>

        <div class="mb-2">
            <span class="fw-semibold">الصف الدراسي:</span>
            <span class="text-muted">{{ $section->grade->name }}</span>
        </div>

        <div class="d-flex gap-2 mt-4">
            <a href="{{ route('section.edit', $section->id) }}"
               class="btn btn-primary-custom">
                <i class="bi bi-pencil-square ms-1"></i> تعديل
            </a>

            <a href="{{ route('section.index') }}"
               class="btn btn-outline-secondary">
                رجوع
            </a>
        </div>

    </div>
</div>

@endsection
