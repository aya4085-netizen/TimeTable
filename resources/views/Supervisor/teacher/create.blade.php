@extends('layout.app')

@section('title','إضافة معلّم جديد')

@section('content')

    <h1 class="main-title">إضافة معلّم جديد</h1>

    <div class="card card-soft">
        <div class="card-body">
            <form method="POST" action="{{ route('teacher.store') }}" class="row g-3">
                @csrf

                {{-- ربط بحساب مستخدم (User) --}}
                <div class="col-12 col-md-6">
                    <label for="user_id" class="form-label">حساب المستخدم</label>
                    <select id="user_id"
                            name="user_id"
                            class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">اختر مستخدماً...</option>
                        @foreach($user as $u)
                            <option value="{{ $u->id }}"
                                {{ old('user_id') == $u->id ? 'selected' : '' }}>
                                {{ $u->name ?? $u->email }} (ID: {{ $u->id }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- الاسم الكامل --}}
                <div class="col-12 col-md-6">
                    <label for="full_name" class="form-label">الاسم الكامل للمعلّم</label>
                    <input type="text"
                           id="full_name"
                           name="full_name"
                           class="form-control @error('full_name') is-invalid @enderror"
                           value="{{ old('full_name') }}"
                           placeholder="مثال: أحمد محمد علي">
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- رقم الهاتف --}}
                <div class="col-12 col-md-6">
                    <label for="phonenumber" class="form-label">رقم الهاتف</label>
                    <input type="text"
                           id="phonenumber"
                           name="phonenumber"
                           class="form-control @error('phonenumber') is-invalid @enderror"
                           value="{{ old('phonenumber') }}"
                           placeholder="مثال: 0912345678">
                    @error('phonenumber')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                {{-- أزرار --}}
                <div class="col-12 d-flex justify-content-start gap-2 mt-3">
                    <button type="submit" class="btn btn-primary-custom">
                        <i class="bi bi-check-lg ms-1"></i> حفظ
                    </button>

                    <a href="{{ route('teacher.index') }}" class="btn btn-outline-secondary">
                        إلغاء
                    </a>
                </div>

            </form>
        </div>
    </div>

@endsection
