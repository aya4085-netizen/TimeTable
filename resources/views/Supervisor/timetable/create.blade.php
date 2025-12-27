@extends('layout.app')

@section('title','إضافة جدول دراسي')

@section('content')

    <h1 class="main-title">إضافة جدول دراسي جديد</h1>

    <div class="card card-soft">
        <div class="card-body">
            <form method="POST" action="{{ route('timetable.store') }}" class="row g-3">
                @csrf

                {{-- الصف --}}
                <div class="col-12 col-md-4">
                    <label for="grade_id" class="form-label">الصف</label>
                    <select id="grade_id"
                            name="grade_id"
                            class="form-select @error('grade_id') is-invalid @enderror">
                        <option value="">اختر صفاً...</option>
                        @foreach($grades as $g)
                            <option value="{{ $g->id }}"
                                {{ old('grade_id') == $g->id ? 'selected' : '' }}>
                                {{ $g->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('grade_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الفصل --}}
                <div class="col-12 col-md-4">
                    <label for="section_id" class="form-label">الفصل</label>
                    <select id="section_id"
                            name="section_id"
                            class="form-select @error('section_id') is-invalid @enderror">
                        <option value="">اختر فصلاً...</option>
                        @foreach($sections as $s)
                            <option value="{{ $s->id }}"
                                {{ old('section_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }} ({{ $s->grade->name ?? '' }})
                            </option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- السنة الدراسية --}}
                <div class="col-12 col-md-4">
                    <label for="year" class="form-label">السنة الدراسية</label>
                    <input type="number"
                           id="year"
                           name="year"
                           class="form-control @error('year') is-invalid @enderror"
                           value="{{ old('year', date('Y')) }}"
                           min="2000" max="2100">
                    @error('year')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> حفظ
                    </button>
                    <a href="{{ route('timetable.index') }}" class="btn btn-outline-secondary">
                        إلغاء
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
