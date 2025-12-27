@extends('layout.app')

@section('title','طلباتي')

@section('content')

@php
    $dayNames = [
        'sat' => 'السبت',
        'sun' => 'الأحد',
        'mon' => 'الإثنين',
        'tue' => 'الثلاثاء',
        'wed' => 'الأربعاء',
        'thu' => 'الخميس',
    ];
@endphp

<h1 class="main-title">طلباتي لتغيير الجدول</h1>

@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card card-soft">
  <div class="card-body p-0">
    <table class="table mb-0 align-middle text-center">
      <thead>
        <tr>
          <th>#</th>
          <th>الحصة</th>
          <th>السبب</th>
          <th>الحالة</th>
          <th>رد المشرف</th>
          <th>تاريخ الرد</th>
        </tr>
      </thead>
      <tbody>
      @forelse($requests as $r)
        @php
          $dayCode = $r->session?->day;
          $dayText = $dayNames[$dayCode] ?? $dayCode ?? '—';

          $st = $r->session?->start_time ? substr($r->session->start_time,0,5) : '—';
          $et = $r->session?->end_time   ? substr($r->session->end_time,0,5)   : '—';
        @endphp

        <tr>
          <td>{{ $loop->iteration }}</td>

          <td>
            <div class="fw-semibold">
              {{ $dayText }} | {{ $st }} - {{ $et }}
            </div>
            <div class="small text-muted">
              {{ $r->session?->subject?->name ?? '-' }}
            </div>
          </td>

          <td>{{ $r->reason ?? '-' }}</td>

          <td>
            @if($r->status === 'pending')
              <span class="badge text-bg-warning">قيد المراجعة</span>
            @elseif($r->status === 'approved')
              <span class="badge text-bg-success">تم القبول</span>
            @else
              <span class="badge text-bg-danger">تم الرفض</span>
            @endif
          </td>

          <td>{{ $r->supervisor_note ?? '—' }}</td>
          <td class="small text-muted">{{ $r->responded_at ?? '—' }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="6" class="py-4">لا توجد طلبات.</td>
        </tr>
      @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection
