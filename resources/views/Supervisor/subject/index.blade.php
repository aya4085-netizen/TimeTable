@extends('layout.app')

@section('title','المواد الدراسية')

@section('content')

    <h1 class="main-title">المواد الدراسية</h1>

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form class="d-flex search-input" method="GET" action="{{ route('subject.search') }}">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="بحث عن مادة..."
                   value="{{ request('search') }}">
        </form>

        <a href="{{ route('subject.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg ms-1"></i> إضافة مادة جديدة
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-soft">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle text-center">
                <thead>
                <tr>
                    <th style="width: 80px;">#</th>
                    <th>اسم المادة</th>
                    <th>الحد الأسبوعي للحصص</th>
                    <th style="width: 180px;">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($subject as $s)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $s->name }}</td>
                        <td>{{ $s->weekly_limit }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('subject.show', $s->id) }}"
                                   class="btn btn-link p-0 action-icon" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('subject.edit', $s->id) }}"
                                   class="btn btn-link p-0 action-icon" title="تعديل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('subject.destroy', $s->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذه المادة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="btn btn-link p-0 action-icon"
                                            title="حذف">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="py-4">لا توجد مواد مسجلة حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
