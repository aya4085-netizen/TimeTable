@extends('layout.app')

@section('title','تفاصيل المادة')

@section('content')

    <h1 class="main-title">تفاصيل المادة</h1>

    <div class="card card-soft">
        <div class="card-body">

            <dl class="row mb-0">

                <dt class="col-sm-3">اسم المادة</dt>
                <dd class="col-sm-9">{{ $subject->name }}</dd>

                <dt class="col-sm-3">عدد الحصص الأسبوعية</dt>
                <dd class="col-sm-9">{{ $subject->weekly_limit }}</dd>

                <dt class="col-sm-3">تاريخ الإنشاء</dt>
                <dd class="col-sm-9">
                    {{ $subject->created_at ? $subject->created_at->format('Y-m-d H:i') : '-' }}
                </dd>

                <dt class="col-sm-3">آخر تحديث</dt>
                <dd class="col-sm-9">
                    {{ $subject->updated_at ? $subject->updated_at->format('Y-m-d H:i') : '-' }}
                </dd>

            </dl>

            <div class="mt-4 d-flex gap-2">
                <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-primary-custom">
                    <i class="bi bi-pencil-square ms-1"></i> تعديل
                </a>

                <a href="{{ route('subject.index') }}" class="btn btn-outline-secondary">
                    رجوع إلى قائمة المواد
                </a>
            </div>

        </div>
    </div>

@endsection
