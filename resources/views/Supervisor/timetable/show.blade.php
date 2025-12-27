@extends('layout.app')

@section('title','عرض الجدول الدراسي')

@section('content')

    <h1 class="main-title">الجدول الدراسي</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <div class="fw-semibold">
            السنة: <span class="text-muted">{{ $timetable->year }}</span> |
            الصف: <span class="text-muted">{{ $timetable->grade->name ?? '-' }}</span> |
            الفصل: <span class="text-muted">{{ $timetable->section->name ?? '-' }}</span>
        </div>

        <a href="{{ route('timetable.index') }}" class="btn btn-outline-secondary">
            رجوع
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- ✅ ثوابت الصفحة (الأيام + الفترات) --}}
    @php
        $days = ['sat','sun','mon','tue','wed','thu'];
        $dayNames = [
            'sat'=>'السبت','sun'=>'الأحد','mon'=>'الإثنين',
            'tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس'
        ];

        // 🔒 فترات ثابتة (باش الجدول ما يتحركش بعد الحذف)
        $timeRows = collect([
            '08:00 - 08:45',
            '08:45 - 09:30',
            '09:30 - 10:15',
            '10:15 - 11:00',
            '11:00 - 11:45',
            '11:45 - 12:30',
        ]);
    @endphp


    {{-- إضافة حصة --}}
    <div class="card card-soft mb-3">
        <div class="card-body">
            <h5 class="fw-bold mb-3">إضافة حصة</h5>

            <form method="POST" action="{{ route('timetable.sessions.store', $timetable->id) }}" class="row g-3">
                @csrf

                <div class="col-12 col-md-3">
                    <label class="form-label">اليوم</label>
                    <select name="day" class="form-select" required>
                        @foreach($days as $d)
                            <option value="{{ $d }}" {{ old('day') == $d ? 'selected' : '' }}>
                                {{ $dayNames[$d] }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- ✅ Dropdown واحد للوقت --}}
                <div class="col-12 col-md-4">
                    <label class="form-label">الوقت</label>
                    <select name="time_range" class="form-select" required>
                        <option value="">اختر الوقت...</option>
                        @foreach($timeRows as $tr)
                            <option value="{{ $tr }}" {{ old('time_range') == $tr ? 'selected' : '' }}>
                                {{ $tr }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3">
                    <label class="form-label">المادة</label>
                    <select name="subject_id" class="form-select" required>
                        <option value="">اختر مادة...</option>
                        @foreach($subjects as $s)
                            <option value="{{ $s->id }}" {{ old('subject_id') == $s->id ? 'selected' : '' }}>
                                {{ $s->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-2">
                    <label class="form-label">المعلم</label>
                    <select name="teacher_id" class="form-select" required>
                        <option value="">اختر معلماً...</option>
                        @foreach($teachers as $t)
                            <option value="{{ $t->id }}" {{ old('teacher_id') == $t->id ? 'selected' : '' }}>
                                {{ $t->full_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-plus-lg ms-1"></i> إضافة
                    </button>
                </div>
            </form>

        </div>
    </div>


    {{-- ✅ نبني Grid من السيشنز --}}
    @php
        $grid = [];
        foreach($sessions as $s){
            // توحيد الوقت إلى H:i (باش ما يصيرش mismatch بسبب الثواني)
            $st = substr($s->start_time, 0, 5);
            $et = substr($s->end_time, 0, 5);
            $key = $st.' - '.$et;

            $grid[$key][$s->day] = $s;
        }
    @endphp


    <div class="card card-soft">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0 align-middle text-center">
                    <thead>
                        <tr>
                            <th style="width:160px;">الوقت</th>
                            @foreach($days as $d)
                                <th>{{ $dayNames[$d] }}</th>
                            @endforeach
                        </tr>
                    </thead>

                    <tbody>
                    @forelse($timeRows as $time)
                        <tr>
                            <td class="fw-semibold">{{ $time }}</td>

                            @foreach($days as $d)
                                @php $cell = $grid[$time][$d] ?? null; @endphp

                                <td style="min-width:160px;">
                                    @if($cell)

                                        <div class="p-2 rounded bg-white position-relative">
                                            <div class="d-flex justify-content-between align-items-start">

                                                <div class="text-start">
                                                    <div class="fw-bold" style="color: var(--primary-color);">
                                                        {{ $cell->subject->name ?? '-' }}
                                                    </div>
                                                    <div class="text-muted small">
                                                        {{ $cell->teacher->full_name ?? '-' }}
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    {{-- تعديل --}}
                                                    <button type="button"
                                                            class="btn btn-link p-0 action-icon"
                                                            title="تعديل"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editSession{{ $cell->id }}">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </button>

                                                    {{-- حذف --}}
                                                    <form action="{{ route('timetable.sessions.destroy', [$timetable->id, $cell->id]) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('هل أنت متأكد من حذف الحصة؟');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0 action-icon" title="حذف">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>

                                        {{-- Modal التعديل (داخل if) --}}
                                        <div class="modal fade" id="editSession{{ $cell->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">تعديل الحصة</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>

                                                    <form method="POST" action="{{ route('timetable.sessions.update', [$timetable->id, $cell->id]) }}">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="modal-body">
                                                            <div class="row g-3">

                                                                <div class="col-12">
                                                                    <label class="form-label">اليوم</label>
                                                                    <select name="day" class="form-select" required>
                                                                        @foreach($days as $dd)
                                                                            <option value="{{ $dd }}" {{ $cell->day == $dd ? 'selected' : '' }}>
                                                                                {{ $dayNames[$dd] }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                {{-- ✅ وقت التعديل نفس الفترات الثابتة --}}
                                                                @php
                                                                    $currentRange = substr($cell->start_time,0,5).' - '.substr($cell->end_time,0,5);
                                                                @endphp
                                                                <div class="col-12">
                                                                    <label class="form-label">الوقت</label>
                                                                    <select name="time_range" class="form-select" required>
                                                                        @foreach($timeRows as $tr)
                                                                            <option value="{{ $tr }}" {{ $currentRange == $tr ? 'selected' : '' }}>
                                                                                {{ $tr }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="form-label">المادة</label>
                                                                    <select name="subject_id" class="form-select" required>
                                                                        @foreach($subjects as $sub)
                                                                            <option value="{{ $sub->id }}" {{ $cell->subject_id == $sub->id ? 'selected' : '' }}>
                                                                                {{ $sub->name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="col-12">
                                                                    <label class="form-label">المعلم</label>
                                                                    <select name="teacher_id" class="form-select" required>
                                                                        @foreach($teachers as $tt)
                                                                            <option value="{{ $tt->id }}" {{ $cell->teacher_id == $tt->id ? 'selected' : '' }}>
                                                                                {{ $tt->full_name }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                            </div>
                                                        </div>

                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">إلغاء</button>
                                                            <button type="submit" class="btn btn-primary-custom">حفظ التعديل</button>
                                                        </div>

                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4">لا توجد حصص بعد.</td>
                        </tr>
                    @endforelse
                    </tbody>

                </table>
            </div>
        </div>
       <div class="d-flex gap-2 mb-3">
    @if($timetable->published_at)
        <form method="POST" action="{{ route('timetable.unpublish', $timetable->id) }}">
            @csrf
            @method('PUT')
            <button class="btn btn-outline-secondary">
                <i class="bi bi-eye-slash ms-1"></i> إلغاء النشر
            </button>
        </form>
    @else
        <form method="POST" action="{{ route('timetable.publish', $timetable->id) }}">
            @csrf
            @method('PUT')
            <button class="btn btn-primary-custom">
                <i class="bi bi-megaphone ms-1"></i> نشر الجدول
            </button>
        </form>
    @endif

    @if($timetable->published_at)
        <div class="text-muted small d-flex align-items-center">
            منشور بتاريخ: {{ $timetable->published_at }}
        </div>
    @endif
</div>

@endsection
