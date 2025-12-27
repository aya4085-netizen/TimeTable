@extends('layout.app')

@section('title','بيانات الطالب')

@section('content')

<h1 class="main-title">بيانات الطالب</h1>

<div class="d-flex justify-content-between align-items-center mb-3">
    <div class="fw-semibold text-muted">
        عرض بيانات طالب
    </div>

    <a href="{{ route('registrar.students.index') }}" class="btn btn-outline-secondary">
        رجوع
    </a>
</div>

<div class="row g-3">

    {{-- بيانات الطالب --}}
    <div class="col-12 col-md-6">
        <div class="card card-soft h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">معلومات الطالب</h5>

                <div class="mb-2">
                    <span class="text-muted">الاسم الكامل:</span><br>
                    <span class="fw-semibold">{{ $student->full_name }}</span>
                </div>

                <div class="mb-2">
                    <span class="text-muted">تاريخ الميلاد:</span><br>
                    <span class="fw-semibold">{{ $student->date_of_birth }}</span>
                </div>

                <div class="mb-2">
                    <span class="text-muted">الصف:</span><br>
                    <span class="fw-semibold">{{ $student->grade->name ?? '—' }}</span>
                </div>

                <div class="mb-2">
                    <span class="text-muted">الفصل:</span><br>
                    <span class="fw-semibold">{{ $student->section->name ?? '—' }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- بيانات الحساب --}}
    <div class="col-12 col-md-6">
        <div class="card card-soft h-100">
            <div class="card-body">
                <h5 class="fw-bold mb-3">بيانات الحساب</h5>

                <div class="mb-2">
                    <span class="text-muted">الإيميل:</span><br>
                    <span class="fw-semibold">{{ $student->user->email ?? '—' }}</span>
                </div>

                <div class="mb-2">
                    <span class="text-muted">الدور:</span><br>
                    <span class="badge text-bg-secondary">
                        طالب
                    </span>
                </div>

                <div class="mb-2">
                    <span class="text-muted">تاريخ إنشاء الحساب:</span><br>
                    <span class="fw-semibold">
                        {{ $student->user->created_at?->format('Y-m-d') ?? '—' }}
                    </span>
                </div>
            </div>
        </div>
    </div>

</div>


@endsection
