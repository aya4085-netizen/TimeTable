@extends('layout.app')

@section('title','لوحة المشرف')

@section('content')

<h1 class="main-title">لوحة تحكم المشرف</h1>

<div class="row g-3">

    {{-- المستخدمون --}}
    <div class="col-12 col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-people-fill fs-1" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold fs-4">{{ $usersCount }}</div>
                    <div class="text-muted">إجمالي المستخدمين</div>
                </div>
            </div>
        </div>
    </div>

    {{-- المعلمون --}}
    <div class="col-12 col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-person-badge-fill fs-1" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold fs-4">{{ $teachersCount }}</div>
                    <div class="text-muted">المعلمون</div>
                </div>
            </div>
        </div>
    </div>

    {{-- المواد --}}
    <div class="col-12 col-md-4">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-journal-bookmark-fill fs-1" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold fs-4">{{ $subjectsCount }}</div>
                    <div class="text-muted">المواد</div>
                </div>
            </div>
        </div>
    </div>

    {{-- الصفوف --}}
    <div class="col-12 col-md-6">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-collection-fill fs-1" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold fs-4">{{ $gradesCount }}</div>
                    <div class="text-muted">الصفوف</div>
                </div>
            </div>
        </div>
    </div>

    {{-- الفصول --}}
    <div class="col-12 col-md-6">
        <div class="card card-soft h-100">
            <div class="card-body d-flex align-items-center gap-3">
                <i class="bi bi-grid-3x3-gap-fill fs-1" style="color: var(--primary-color);"></i>
                <div>
                    <div class="fw-bold fs-4">{{ $sectionsCount }}</div>
                    <div class="text-muted">الفصول</div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
