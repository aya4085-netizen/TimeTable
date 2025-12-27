@extends('layout.app')

@section('title','الجداول الدراسية')

@section('content')

    <h1 class="main-title">الجداول الدراسية</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form class="d-flex search-input" method="GET" action="{{ route('timetable.search') }}">
            <input type="text" name="search" class="form-control" placeholder="بحث (سنة/صف/فصل)..."
                   value="{{ request('search') }}">
        </form>

        <a href="{{ route('timetable.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg ms-1"></i> إنشاء جدول جديد
        </a>
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
                    <th style="width: 80px;">#</th>
                    <th>السنة</th>
                    <th>الصف</th>
                    <th>الفصل</th>
                    <th style="width: 200px;">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($timetables as $timetable)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $timetable->year }}</td>
                        <td>{{ $timetable->grade->name ?? '-' }}</td>
                        <td>{{ $timetable->section->name ?? '-' }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('timetable.show', $timetable->id) }}"
                                   class="btn btn-link p-0 action-icon" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('timetable.edit', $timetable->id) }}"
                                   class="btn btn-link p-0 action-icon" title="تعديل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('timetable.destroy', $timetable->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الجدول؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link p-0 action-icon" title="حذف">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-4">لا توجد جداول مسجلة حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
