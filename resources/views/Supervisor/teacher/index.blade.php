@extends('layout.app')

@section('title','المعلّمون')

@section('content')

    <h1 class="main-title">المعلّمون</h1>

    {{-- شريط علوي: بحث + زر إضافة --}}
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <form class="d-flex search-input" method="GET" action="{{ route('teacher.search') }}">
            <input type="text"
                   name="search"
                   class="form-control"
                   placeholder="بحث عن معلّم..."
                   value="{{ request('search') }}">
        </form>

        <a href="{{ route('teacher.create') }}" class="btn btn-primary-custom">
            <i class="bi bi-plus-lg ms-1"></i> إضافة معلّم جديد
        </a>
    </div>

    {{-- رسائل نجاح --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- جدول المعلّمين --}}
    <div class="card card-soft">
        <div class="card-body p-0">
            <table class="table mb-0 align-middle text-center">
                <thead>
                <tr>
                    <th style="width: 60px;">#</th>
                    <th>الاسم الكامل</th>
                    <th>الحساب (المستخدم)</th>
                    <th>رقم الهاتف</th>
                    <th style="width: 180px;">إجراءات</th>
                </tr>
                </thead>
                <tbody>
                @forelse($teacher as $t)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $t->full_name }}</td>
                        <td>
                            {{-- نعرض اسم المستخدم أو الإيميل إن وجد --}}
                            {{ optional($t->user)->email ?? optional($t->user)->email ?? '-' }}
                        </td>
                        <td>{{ $t->phonenumber }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">


                         

                                {{-- تعديل --}}
                                
                                <a href="{{ route('teacher.edit', $t->id) }}"
                                   class="btn btn-link p-0 action-icon" title="تعديل">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                               

                                {{-- حذف --}}
                                <form action="{{ route('teacher.destroy', $t->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا المعلّم؟');">
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
                        <td colspan="5" class="py-4">لا توجد بيانات معلّمين حالياً.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
