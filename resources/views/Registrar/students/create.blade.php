@extends('layout.app')

@section('title','إضافة طالب')

@section('content')

<h1 class="main-title">إضافة طالب</h1>

@if ($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-1">فيه أخطاء في الإدخال:</div>
        <ul class="mb-0">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card card-soft">
    <div class="card-body">
        <form method="POST" action="{{ route('registrar.students.store') }}" class="row g-3">
            @csrf

            {{-- بيانات الحساب --}}
            <div class="col-12">
                <div class="fw-semibold mb-1">بيانات الحساب</div>
            </div>

            <div class="col-12 col-md-6">
    <label class="form-label">الإيميل</label>
    <input type="email" name="email"
           class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email') }}" required>
    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12 col-md-6">
    <label class="form-label">كلمة المرور</label>
    <input type="password" name="password"
           class="form-control @error('password') is-invalid @enderror"
           required>
    @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>

<div class="col-12 col-md-6">
    <label class="form-label">تأكيد كلمة المرور</label>
    <input type="password" name="password_confirmation" class="form-control" required>
</div>


            <hr class="my-2">

            {{-- بيانات الطالب --}}
            <div class="col-12">
                <div class="fw-semibold mb-1">بيانات الطالب</div>
            </div>

            <div class="col-md-6">
                <label class="form-label">اسم الطالب (الملف الدراسي)</label>
                <input type="text"
                       name="full_name"
                       class="form-control @error('full_name') is-invalid @enderror"
                       value="{{ old('full_name') }}"
                       required>
                @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">الصف</label>
                <select name="grade_id" class="form-select @error('grade_id') is-invalid @enderror" required>
                    <option value="">اختر صف...</option>
                    @foreach($grade as $g)
                        <option value="{{ $g->id }}" {{ old('grade_id') == $g->id ? 'selected' : '' }}>
                            {{ $g->name }}
                        </option>
                    @endforeach
                </select>
                @error('grade_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-3">
                <label class="form-label">الفصل</label>
                <select name="section_id" class="form-select @error('section_id') is-invalid @enderror" required>
                    <option value="">اختر فصل...</option>
                    @foreach($section as $s)
                        <option value="{{ $s->id }}" {{ old('section_id') == $s->id ? 'selected' : '' }}>
                            {{ $s->name }}
                        </option>
                    @endforeach
                </select>
                @error('section_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-4">
                <label class="form-label">تاريخ الميلاد</label>
                <input type="date"
                       name="date_of_birth"
                       class="form-control @error('date_of_birth') is-invalid @enderror"
                       value="{{ old('date_of_birth') }}"
                       required>
                @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-12 mt-3 d-flex gap-2">
                <button class="btn btn-primary-custom">
                    <i class="bi bi-check-lg ms-1"></i> حفظ
                </button>
                <a href="{{ route('registrar.students.index') }}" class="btn btn-outline-secondary">
                    إلغاء
                </a>
            </div>
        </form>
    </div>
</div>

@endsection
