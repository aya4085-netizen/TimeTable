@extends('layout.app')

@section('title','تعديل طالب')

@section('content')

{{-- عنوان + زر رجوع (نفس ستايل صفحاتك) --}}
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
    <h1 class="main-title mb-0">تعديل بيانات الطالب</h1>

    <a href="{{ route('registrar.students.index', $student->id) }}" class="btn btn-outline-secondary">
        رجوع
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
    <div class="alert alert-danger">
        <div class="fw-semibold mb-1">راجع الأخطاء:</div>
        <ul class="mb-0">
            @foreach($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('registrar.students.update', $student->id) }}" class="row g-3">
    @csrf
    @method('PUT')

    {{-- كرت معلومات الطالب --}}
    <div class="col-12">
        <div class="card card-soft">
            <div class="card-body">
                <h5 class="fw-bold mb-3">معلومات الطالب</h5>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">اسم الطالب</label>
                        <input type="text"
                               name="full_name"
                               class="form-control @error('full_name') is-invalid @enderror"
                               value="{{ old('full_name', $student->full_name) }}"
                               required>
                        @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    

                    <div class="col-12 col-md-6">
                        <label class="form-label">تاريخ الميلاد</label>
                        <input type="date"
                               name="date_of_birth"
                               class="form-control @error('date_of_birth') is-invalid @enderror"
                               value="{{ old('date_of_birth', $student->date_of_birth) }}"
                               required>
                        @error('date_of_birth') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    

            </div>
        </div>
    </div>

    {{-- كرت بيانات الحساب --}}
    <div class="col-12">
        <div class="card card-soft">
            <div class="card-body">
                <h5 class="fw-bold mb-3">بيانات الحساب</h5>

                <div class="row g-3">
                    <div class="col-12 col-md-6">
                        <label class="form-label">الإيميل</label>
                        <input type="email"
                               name="email"
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $student->user->email ?? '') }}"
                               placeholder="example@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-6">
                        <label class="form-label">الدور</label>
                        <input type="text" class="form-control" value="طالب" disabled>
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- أزرار --}}
    <div class="col-12 d-flex gap-2">
        <button type="submit" class="btn btn-primary-custom">
            <i class="bi bi-check-lg ms-1"></i> حفظ التعديلات
        </button>

        <a href="{{ route('registrar.students.index', $student->id) }}" class="btn btn-outline-secondary">
            إلغاء
        </a>
    </div>

</form>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const gradeSelect = document.getElementById('grade_id');
    const sectionSelect = document.getElementById('section_id');

    function filterSections() {
        const gradeId = gradeSelect.value;
        Array.from(sectionSelect.options).forEach(opt => {
            if (!opt.value) return;
            opt.hidden = gradeId && opt.getAttribute('data-grade') !== gradeId;
        });

        const selected = sectionSelect.options[sectionSelect.selectedIndex];
        if (selected && selected.hidden) sectionSelect.value = '';
    }

    gradeSelect.addEventListener('change', filterSections);
    filterSections();
});
</script>

@endsection
