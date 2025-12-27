@extends('layout.app')

@section('title','تعديل صف دراسي')

@section('content')

    <h1 class="main-title">تعديل صف دراسي</h1>

    <div class="card card-soft">
        <div class="card-body">

            <form action="{{ route('grade.update', $grade->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-12 col-md-6">
                    <label class="form-label">اسم الصف</label>
                    <input type="text" name="name" class="form-control"
                           value="{{ old('name', $grade->name) }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> حفظ التعديلات
                    </button>

                    <a href="{{ route('grade.index') }}" class="btn btn-outline-secondary me-2">
                        رجوع
                    </a>
                </div>
            </form>

        </div>
    </div>

@endsection
