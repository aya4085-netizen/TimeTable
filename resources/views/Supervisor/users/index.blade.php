@extends('layout.app')

@section('title','إدارة الحسابات')

@section('content')

<h1 class="main-title">إدارة الحسابات</h1>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <div class="text-muted">هنا تقدر تضيف معلمين وموظف شؤون الطلبة</div>

    <a href="{{ route('supervisor.users.create') }}" class="btn btn-primary-custom">
        <i class="bi bi-plus-lg ms-1"></i> إضافة حساب
    </a>
</div>

<div class="card card-soft">
    <div class="card-body p-0">
        <table class="table mb-0 align-middle text-center">
            <thead>
            <tr>
                <th>#</th>
                <th>الاسم</th>
                <th>الإيميل</th>
                <th>الدور</th>
                <th style="width:140px;">إجراءات</th>
            </tr>
            </thead>
            <tbody>
            @forelse($users as $u)
                <tr>
                    <td>{{ $u->id }}</td>
                    <td>{{ $u->name }}</td>
                    <td>{{ $u->email }}</td>
                    <td>{{ $u->role }}</td>
                    <td>
                        <form method="POST" action="{{ route('supervisor.users.destroy',$u->id) }}"
                              onsubmit="return confirm('هل أنت متأكد من حذف الحساب؟');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-link p-0 action-icon" title="حذف">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="py-4">لا توجد حسابات</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
