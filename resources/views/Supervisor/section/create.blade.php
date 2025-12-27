@extends('layout.app')

@section('title','إضافة فصل جديد')

@section('content')

    <h1 class="main-title">إضافة فصل جديد</h1>

    <div class="card card-soft">
        <div class="card-body">

            <form action="{{ route('section.store') }}" method="POST" class="row g-3">
                @csrf

                {{-- اختيار الصف --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">الصف الدراسي</label>
                    <select name="grade_id" class="form-control">
                        <option value="">اختر الصف</option>

                        @foreach($grade as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                        @endforeach

                    </select>

                    @error('grade_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- اسم الفصل --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">اسم الفصل</label>
                    <input type="text" name="name" class="form-control"
                           placeholder="مثال: 1 / أ">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-circle ms-1"></i> حفظ
                    </button>

                    <a href="{{ route('section.index') }}" class="btn btn-outline-secondary me-2">
                        إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
