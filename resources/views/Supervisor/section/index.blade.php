@extends('layout.app')

@section('title','الفصول الدراسية')

@section('content')

    <h1 class="main-title">الفصول الدراسية</h1>

    {{-- شريط علوي: بحث + إضافة فصل --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">

        <form class="d-flex search-input" method="GET" action="{{ route('section.search') }}">
            <input type="text" name="search" class="form-control"
                   placeholder="بحث عن فصل..."
                   value="{{ request('search') }}">
        </form>

        <a href="{{ route('section.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg ms-1"></i> إضافة فصل جديد
        </a>

    </div>

    {{-- رسالة نجاح --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- جدول الفصول --}}
    <div class="card card-soft">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle text-center">
                <thead>
                <tr>
                    <th style="width: 80px;">#</th>
                    <th>اسم الفصل</th>
                    <th>الصف الدراسي</th>
                    <th style="width: 180px;">إجراءات</th>
                </tr>
                </thead>

                <tbody>
                @forelse($section as $sec)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $sec->name }}</td>
                        <td>{{ $sec->grade->name }}</td>

                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <a href="{{ route('section.show', $sec->id) }}"
                                   class="btn btn-link p-0 action-icon" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('section.edit', $sec->id) }}"
                                   class="btn btn-link p-0 action-icon" title="تعديل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('section.destroy', $sec->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('هل تريد حذف هذا الفصل؟');">
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
                        <td colspan="4" class="py-3">لا توجد فصول حالياً</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>

@endsection
