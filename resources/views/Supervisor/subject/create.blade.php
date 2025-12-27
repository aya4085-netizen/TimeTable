@extends('layout.app')

@section('title','إضافة مادة جديدة')

@section('content')

    <h1 class="main-title">إضافة مادة جديدة</h1>

    <div class="card card-soft">
        <div class="card-body">

            <form method="POST" action="{{ route('subject.store') }}" class="row g-3">
                @csrf

                {{-- اسم المادة --}}
                <div class="col-12">
                    <label for="name" class="form-label">اسم المادة</label>
                    <input type="text"
                           id="name"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="مثال: الرياضيات"
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الحد الأسبوعي للحصص --}}
                <div class="col-12 col-md-6">
                    <label for="weekly_limit" class="form-label">عدد الحصص الأسبوعية</label>
                    <input type="number"
                           id="weekly_limit"
                           name="weekly_limit"
                           class="form-control @error('weekly_limit') is-invalid @enderror"
                           placeholder="مثال: 5"
                           min="1"
                           value="{{ old('weekly_limit') }}">
                    @error('weekly_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- أزرار --}}
                <div class="col-12 d-flex justify-content-start gap-2 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> حفظ
                    </button>

                    <a href="{{ route('subject.index') }}" class="btn btn-outline-secondary">
                        إلغاء
                    </a>
                </div>
            </form>

        </div>
    </div>

@endsection
