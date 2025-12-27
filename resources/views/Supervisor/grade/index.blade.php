@extends('layout.app')

@section('title','الصفوف الدراسية')

@section('content')

    <h1 class="main-title">الصفوف الدراسية</h1>

    {{-- شريط علوي: زر إضافة + بحث بسيط (اختياري) --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
       <form class="d-flex search-input" method="GET" action="{{ route('grade.search') }}">
    <input type="text" name="name" class="form-control" placeholder="بحث عن صف..."
           value="{{ request('name') }}">
</form>


        <a href="{{ route('grade.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg ms-1"></i> إضافة صف جديد
        </a>
    </div>

    {{-- رسائل نجاح --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- جدول الصفوف --}}
    <div class="card card-soft">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle text-center">
                <thead>
                <tr>
                    <th style="width: 80px;">#</th>
                    <th>اسم الصف</th>
                    <th style="width: 180px;">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($grade as $g)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $g->name }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('grade.show', $g->id) }}"
                                   class="btn btn-link p-0 action-icon" title="عرض">
                                    <i class="bi bi-eye"></i>
                                </a>

                                <a href="{{ route('grade.edit', $g->id) }}"
                                   class="btn btn-link p-0 action-icon" title="تعديل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>

                                <form action="{{ route('grade.destroy', $g->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الصف؟');">
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
                        <td colspan="3" class="py-4">لا توجد صفوف مسجلة حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
