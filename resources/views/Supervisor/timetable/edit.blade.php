@extends('layout.app')

@section('title','تعديل جدول')

@section('content')

    <h1 class="main-title">تعديل جدول</h1>

    <div class="card card-soft">
        <div class="card-body">

            <form action="{{ route('timetable.update', $timetable->id) }}" method="POST" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-12 col-md-4">
                    <label class="form-label">السنة الدراسية</label>
                    <input type="number" name="year" class="form-control"
                           value="{{ old('year', $timetable->year) }}" min="2000" max="2100">
                    @error('year')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">الصف</label>
                    <select name="grade_id" class="form-select">
                        @foreach($grades as $g)
                            <option value="{{ $g->id }}" {{ old('grade_id', $timetable->grade_id) == $g->id ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('grade_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 col-md-4">
                    <label class="form-label">الفصل</label>
                    <select name="section_id" class="form-select">
                        @foreach($sections as $s)
                            <option value="{{ $s->id }}" {{ old('section_id', $timetable->section_id) == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('section_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-12 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> تحديث
                    </button>

                    <a href="{{ route('timetable.index') }}" class="btn btn-outline-secondary me-2">
                        إلغاء
                    </a>
                </div>

            </form>

        </div>
    </div>

@endsection
