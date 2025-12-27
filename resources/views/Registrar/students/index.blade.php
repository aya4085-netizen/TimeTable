@extends('layout.app')

@section('title','إدارة الطلبة')

@section('content')

<h1 class="main-title">إدارة الطلبة</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

    {{-- فلاتر وبحث --}}
    <form class="d-flex gap-2 flex-wrap" method="GET" action="{{ route('registrar.students.index') }}">
        <input type="text"
               name="search"
               class="form-control"
               style="max-width:260px;"
               placeholder="بحث بالاسم أو الإيميل..."
               value="{{ request('search') }}">

        <select name="grade_id" class="form-select" style="max-width:220px;">
            <option value="">كل الصفوف</option>
            @foreach($grades as $g)
                <option value="{{ $g->id }}" {{ request('grade_id') == $g->id ? 'selected' : '' }}>
                    {{ $g->name }}
                </option>
            @endforeach
        </select>

        <select name="section_id" class="form-select" style="max-width:220px;">
            <option value="">كل الفصول</option>
            @foreach($sections as $s)
                <option value="{{ $s->id }}" {{ request('section_id') == $s->id ? 'selected' : '' }}>
                    {{ $s->name }} ({{ $s->grade->name ?? '' }})
                </option>
            @endforeach
        </select>

        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search ms-1"></i> بحث
        </button>

        <a class="btn btn-outline-secondary" href="{{ route('registrar.students.index') }}">
            <i class="bi bi-arrow-counterclockwise ms-1"></i> تصفير
        </a>
    </form>

    {{-- إضافة --}}
    <a href="{{ route('registrar.students.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg ms-1"></i> إضافة طالب
    </a>
</div>


<div class="card card-soft">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0 align-middle text-center">
                <thead>
                    <tr>
                        <th style="width:70px;">#</th>
                        <th>الطالب</th>
                        <th>الإيميل</th>
                        <th>الصف</th>
                        <th>الفصل</th>
                        <th>تاريخ الميلاد</th>
                        <th style="width:160px;">إجراءات</th>
                    </tr>
                </thead>

                <tbody>
                @forelse($students as $st)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-semibold">{{ $st->full_name }}</td>

                        <td class="text-muted">
                            {{ $st->user->email ?? '—' }}
                        </td>

                        <td>{{ $st->grade->name ?? '—' }}</td>
                        <td>{{ $st->section->name ?? '—' }}</td>

                        <td class="text-muted">{{ $st->date_of_birth ?? '—' }}</td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('registrar.students.show', $st->id) }}"
                                   class="btn btn-link p-0 action-icon" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('registrar.students.edit', $st->id) }}"
                                   class="btn btn-link p-0 action-icon" title="تعديل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('registrar.students.destroy', $st->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف الطالب؟');">
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
                        <td colspan="7" class="py-4">لا يوجد طلبة حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@if($students->hasPages())
    <div class="mt-3">
        {{ $students->links() }}
    </div>
@endif

@endsection
