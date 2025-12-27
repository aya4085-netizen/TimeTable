@extends('layout.auth')

@section('title','تسجيل الدخول')

@section('content')

<div class="d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 40px);">
    <div class="card card-soft" style="max-width: 480px; width:100%;">
        <div class="card-body p-4">

            <h3 class="fw-bold mb-1" style="color: var(--primary-color);">تسجيل الدخول</h3>
            <p class="text-muted mb-4">أدخلي البريد الإلكتروني وكلمة المرور</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="row g-3">
                @csrf

                <div class="col-12">
                    <label class="form-label">البريد الإلكتروني</label>
                    <input type="email" name="email" class="form-control"
                           value="{{ old('email') }}" required autofocus>
                </div>

                <div class="col-12">
                    <label class="form-label">كلمة المرور</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="col-12 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                        <label class="form-check-label" for="remember">تذكرني</label>
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary-custom w-100">دخول</button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection