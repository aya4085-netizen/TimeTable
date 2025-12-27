@extends('layout.app')

@section('title','إضافة حساب')

@section('content')

<h1 class="main-title">إضافة حساب جديد</h1>

<div class="card card-soft">
    <div class="card-body">
        <form method="POST" action="{{ route('supervisor.users.store') }}" class="row g-3">
            @csrf

            <div class="col-12 col-md-6">
                <label class="form-label">الاسم</label>
                <input type="text" name="name" class="form-control"
                       value="{{ old('name') }}" required>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">الدور</label>
                <select name="role" class="form-select" required>
                    <option value="">اختر...</option>
                    @foreach($roles as $key=>$label)
                        <option value="{{ $key }}" {{ old('role')==$key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="col-12 col-md-6">
                <label class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="col-12 d-flex gap-2 mt-2">
                <button class="btn btn-primary-custom">
                    <i class="bi bi-check-lg ms-1"></i> حفظ
                </button>
                <a href="{{ route('supervisor.users.index') }}" class="btn btn-outline-secondary">رجوع</a>
            </div>

        </form>
    </div>
</div>

@endsection
