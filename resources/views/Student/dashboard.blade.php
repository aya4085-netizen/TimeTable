@extends('layout.app')

@section('title','جدولي الدراسي')

@section('content')

<h1 class="main-title">جدولي الدراسي</h1>

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif

{{-- 🔒 حماية من undefined variables --}}
@php
    $sessions = $sessions ?? collect();
    $student  = $student  ?? null;
@endphp

<div class="card card-soft mb-3">
  <div class="card-body">
    <div class="fw-semibold mb-1">
      الطالب: <span class="text-muted">{{ $student->full_name }}</span>
    </div>
    <div class="text-muted small">
      الصف: {{ $student->grade->name ?? '-' }} |
      الفصل: {{ $student->section->name ?? '-' }}
    
    </div>
  </div>
</div>

@php
  $days = ['sat','sun','mon','tue','wed','thu'];
  $dayNames = [
    'sat'=>'السبت','sun'=>'الأحد','mon'=>'الإثنين',
    'tue'=>'الثلاثاء','wed'=>'الأربعاء','thu'=>'الخميس'
  ];

  $timeRows = collect([
    '08:00 - 08:45',
    '08:45 - 09:30',
    '09:30 - 10:15',
    '10:15 - 11:00',
    '11:00 - 11:45',
    '11:45 - 12:30',
  ]);

  $grid = [];
  foreach($sessions as $s){
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
                      {{ $cell->teacher->full_name ?? '-' }}
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
