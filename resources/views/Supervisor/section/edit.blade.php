@extends('layout.app')

@section('title','تعديل فصل')

@section('content')

    <h1 class="main-title">تعديل فصل</h1>

    <div class="card card-soft">
        <div class="card-body">

            <form action="{{ route('section.update', $section->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                {{-- الصف --}}
                <div class="col-12 col-md-6">
                    <label class="form-label">الصف الدراسي</label>
                    <select name="grade_id" class="form-control">

                        @foreach($grade as $g)
                            <option value="{{ $g->id }}"
                                    @if($g->id == $section->grade_id) selected @endif>
                                {{ $g->name }}
                            </option>
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
                           value="{{ $section->name }}">
                    @error('name')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-circle ms-1"></i> حفظ التعديلات
                    </button>

                    <a href="{{ route('section.index') }}" class="btn btn-outline-secondary me-2">
                        رجوع
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
