@extends('layout.app')

@section('title','تفاصيل معلّم')

@section('content')

    <h1 class="main-title">تفاصيل المعلّم</h1>

    <div class="card card-soft">
        <div class="card-body">

            <dl class="row mb-0">

                <dt class="col-sm-3">الاسم الكامل</dt>
                <dd class="col-sm-9">{{ $teacher->full_name }}</dd>

                <dt class="col-sm-3">حساب المستخدم</dt>
                <dd class="col-sm-9">
                    {{ optional($teacher->user)->name ?? optional($teacher->user)->email ?? '-' }}
                </dd>

                <dt class="col-sm-3">رقم الهاتف</dt>
                <dd class="col-sm-9">{{ $teacher->phonenumber }}</dd>

                <dt class="col-sm-3">تاريخ الإنشاء</dt>
                <dd class="col-sm-9">
                    {{ $teacher->created_at ? $teacher->created_at->format('Y-m-d H:i') : '-' }}
                </dd>

                <dt class="col-sm-3">آخر تحديث</dt>
                <dd class="col-sm-9">
                    {{ $teacher->updated_at ? $teacher->updated_at->format('Y-m-d H:i') : '-' }}
                </dd>

            </dl>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('teacher.edit', $teacher->id) }}" class="btn btn-primary-custom">
                    <i class="bi bi-pencil-square ms-1"></i> تعديل
                </a>

                <a href="{{ route('teacher.index') }}" class="btn btn-outline-secondary">
                    الرجوع إلى قائمة المعلّمين
                </a>
            </div>

        </div>
    </div>

@endsection
