@extends('layout.app')

@section('title','طلبات تغيير الجدول')

@section('content')

<h1 class="main-title">طلبات تغيير الجدول</h1>

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <form method="GET" class="d-flex gap-2">
        <select name="status" class="form-select" style="max-width:220px;">
            <option value="">كل الحالات</option>
            <option value="pending"  {{ request('status')=='pending' ? 'selected':'' }}>قيد الانتظار</option>
            <option value="approved" {{ request('status')=='approved' ? 'selected':'' }}>مقبول</option>
            <option value="rejected" {{ request('status')=='rejected' ? 'selected':'' }}>مرفوض</option>
        </select>
        <button class="btn btn-primary-custom">
            <i class="bi bi-search ms-1"></i> فلترة
        </button>
    </form>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card card-soft">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المعلم</th>
                    <th>الحصة</th>
                    <th>الحالة</th>
                    <th>عرض</th>
                </tr>
            </thead>
            <tbody>
            @forelse($requests as $r)
                <tr>
                    <td>{{ $r->id }}</td>
                    <td>{{ $r->teacher->full_name ?? ($r->teacher->user->name ?? '-') }}</td>
                    <td>
                        {{ $r->session->subject->name ?? '-' }}
                        <div class="text-muted small">
                            {{ $r->timetable->grade->name ?? '-' }} - {{ $r->timetable->section->name ?? '-' }}
                            | سنة: {{ $r->timetable->year }}
                        </div>
                    </td>
                    <td>
                        @if($r->status === 'pending')
                            <span class="badge bg-warning text-dark">قيد الانتظار</span>
                        @elseif($r->status === 'approved')
                            <span class="badge bg-success">مقبول</span>
                        @else
                            <span class="badge bg-danger">مرفوض</span>
                        @endif
                    </td>
                    <td>
                        <a class="btn btn-link p-0 action-icon"
                           href="{{ route('change_requests.show', $r->id) }}" title="عرض">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-4">لا توجد طلبات.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
