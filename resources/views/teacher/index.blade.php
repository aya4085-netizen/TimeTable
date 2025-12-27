@extends('layout.app')

@section('title','جدولي الدراسي')

@section('content')

<h1 class="main-title">جدولي الدراسي</h1>

<div class="mb-3 fw-semibold">
    المعلّم: <span class="text-muted">{{ $teacher->full_name }}</span>
</div>

@php
    $days = ['sat','sun','mon','tue','wed','thu'];
    $dayNames = [
        'sat'=>'السبت','sun'=>'الأحد','mon'=>'الإثنين',
        'tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس'
    ];

    // فترات ثابتة
    $timeRows = collect([
        '08:00 - 08:45',
        '08:45 - 09:30',
        '09:30 - 10:15',
        '10:15 - 11:00',
        '11:00 - 11:45',
        '11:45 - 12:30',
    ]);

    // ✅ Grid مع توحيد الوقت إلى H:i (بدون ثواني)
    $grid = [];
    foreach($sessions as $s){
        $st = substr($s->start_time, 0, 5);
        $et = substr($s->end_time,   0, 5);
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
                @foreach($timeRows as $time)
                    <tr>
                        <td class="fw-semibold">{{ $time }}</td>

                        @foreach($days as $d)
                            @php $cell = $grid[$time][$d] ?? null; @endphp
                            <td style="min-width:180px;">
                                @if($cell)
                                    <div class="p-2 rounded bg-white">
                                        <div class="fw-bold" style="color: var(--primary-color);">
                                            {{ $cell->subject->name ?? '-' }}
                                        </div>

                                        <div class="small text-muted">
                                            {{ $cell->timetable->grade->name ?? '-' }} -
                                            {{ $cell->timetable->section->name ?? '-' }}
                                            | سنة: {{ $cell->timetable->year ?? '-' }}
                                        </div>

                                        <div class="mt-2">
                                            {{-- لو مازال route الطلب مش جاهز، خليها # مؤقتا --}}
                                           <a href="{{ route('teacher.change_requests.create', $cell->id) }}"
   class="btn btn-sm btn-outline-secondary">
   طلب تغيير
</a>

                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">—</span>
                                @endif
                            </td>
                        @endforeach

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
