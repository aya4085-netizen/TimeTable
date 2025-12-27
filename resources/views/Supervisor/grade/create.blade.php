@extends('layout.app')

@section('title','إضافة صف جديد')

@section('content')

    <h1 class="main-title">إضافة صف جديد</h1>

    <div class="card card-soft">
        <div class="card-body">

            <form action="{{ route('grade.store') }}" method="POST" class="row g-3">
                @csrf

                <div class="col-12 col-md-6">
                    <label class="form-label">اسم الصف</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name') }}" placeholder="مثال: الصف السادس">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> حفظ
                    </button>

                    <a href="{{ route('grade.index') }}" class="btn btn-outline-secondary me-2">
                        إلغاء
                    </a>
                </div>
            </form>

        </div>
    </div>

@endsection
