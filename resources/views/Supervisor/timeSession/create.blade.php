@extends('layout.app')

@section('title','إضافة حصة جديدة')

@section('content')

    <h1 class="main-title">إضافة حصة جديدة</h1>

    <div class="card card-soft mb-3">
        <div class="card-body">
            <strong>الصف:</strong> {{ $timetable->grade->name ?? '-' }} |
            <strong>الفصل:</strong> {{ $timetable->section->name ?? '-' }} |
            <strong>السنة:</strong> {{ $timetable->year }}
        </div>
    </div>

    <div class="card card-soft">
        <div class="card-body">
            <form method="POST"
                  action="{{ route('timetable.sessions.store', $timetable->id) }}"
                  class="row g-3">
                @csrf

                @php
                    $dayNames = [
                        'sat' => 'السبت',
                        'sun' => 'الأحد',
                        'mon' => 'الاثنين',
                        'tue' => 'الثلاثاء',
                        'wed' => 'الأربعاء',
                        'thu' => 'الخميس',
                    ];
                @endphp

                {{-- التوقيت --}}
                <div class="col-12 col-md-6">
                    <label for="timeslot_id" class="form-label">اليوم والوقت</label>
                    <select id="timeslot_id"
                            name="timeslot_id"
                            class="form-select @error('timeslot_id') is-invalid @enderror">
                        <option value="">اختر توقيتاً...</option>
                        @foreach($timeslots as $slot)
                            <option value="{{ $slot->id }}"
                                {{ old('timeslot_id') == $slot->id ? 'selected' : '' }}>
                                {{ $dayNames[$slot->day] ?? $slot->day }}
                                ({{ \Illuminate\Support\Str::of($slot->start_time)->substr(0,5) }}
                                -
                                {{ \Illuminate\Support\Str::of($slot->end_time)->substr(0,5) }})
                            </option>
                        @endforeach
                    </select>
                    @error('timeslot_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- المادة --}}
                <div class="col-12 col-md-6">
                    <label for="subject_id" class="form-label">المادة</label>
                    <select id="subject_id"
                            name="subject_id"
                            class="form-select @error('subject_id') is-invalid @enderror">
                        <option value="">اختر مادة...</option>
                        @foreach($subjects as $sub)
                            <option value="{{ $sub->id }}"
                                {{ old('subject_id') == $sub->id ? 'selected' : '' }}>
                                {{ $sub->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('subject_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- المعلّم --}}
                <div class="col-12 col-md-6">
                    <label for="teacher_id" class="form-label">المعلّم</label>
                    <select id="teacher_id"
                            name="teacher_id"
                            class="form-select @error('teacher_id') is-invalid @enderror">
                        <option value="">اختر معلّماً...</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}"
                                {{ old('teacher_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->full_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('teacher_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الفصل (داخل نفس الصف) --}}
                <div class="col-12 col-md-6">
                    <label for="section_id" class="form-label">الفصل</label>
                    <select id="section_id"
                            name="section_id"
                            class="form-select @error('section_id') is-invalid @enderror">
                        <option value="">اختر فصلاً...</option>
                        @foreach($sections as $s)
                            <option value="{{ $s->id }}"
                                {{ old('section_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('section_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-12 d-flex gap-2 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> حفظ
                    </button>
                    <a href="{{ route('timetable.show', $timetable->id) }}"
                       class="btn btn-outline-secondary">
                        رجوع للجدول
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
