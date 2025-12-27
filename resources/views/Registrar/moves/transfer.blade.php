@extends('layout.app')

@section('title','نقل طالب')

@section('content')

<div class="mx-auto" style="max-width: 980px;">

    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
        <h1 class="main-title mb-0">نقل طالب بين الفصول</h1>

        <a href="{{ route('registrar.students.index') }}" class="btn btn-outline-secondary">
            رجوع
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card card-soft">
        <div class="card-body p-4">

            <form method="POST" action="{{ route('registrar.moves.transfer.store') }}">
                @csrf

                <div class="row g-3">

                    {{-- الطالب (بحث) --}}
                    <div class="col-12 col-md-6 position-relative">
                        <label class="form-label">الطالب</label>

                        <input type="text"
                               id="student_search"
                               class="form-control @error('student_id') is-invalid @enderror"
                               placeholder="اكتب اسم الطالب..."
                               autocomplete="off">

                        <input type="hidden" name="student_id" id="student_id" value="{{ old('student_id') }}">

                        <div id="student_results"
                             class="list-group position-absolute w-100 shadow-sm"
                             style="z-index: 2000; display:none; top: 100%; margin-top: .25rem;">
                        </div>

                        @error('student_id')
                          <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror

                        <div class="form-text">
                            اكتب أول حرفين وسيظهر اقتراحات.
                        </div>
                    </div>

                    {{-- الفصل الجديد --}}
                    <div class="col-12 col-md-6">
                        <label class="form-label">الفصل الجديد</label>

                        <select name="to_section_id"
                                id="to_section_id"
                                class="form-select @error('to_section_id') is-invalid @enderror"
                                required>
                            <option value="">اختر فصل...</option>
                            @foreach($sections as $sec)
                                <option value="{{ $sec->id }}"
                                    {{ old('to_section_id') == $sec->id ? 'selected' : '' }}
                                    data-grade="{{ $sec->grade_id }}">
                                    {{ $sec->grade->name }} - {{ $sec->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('to_section_id')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- سبب النقل --}}
                    <div class="col-12">
                        <label class="form-label">سبب النقل (اختياري)</label>
                        <textarea name="reason"
                                  rows="3"
                                  class="form-control @error('reason') is-invalid @enderror"
                                  >{{ old('reason') }}</textarea>
                        @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- أزرار --}}
                    <div class="col-12 d-flex justify-content-end gap-2 mt-2">
                        <a href="{{ route('registrar.students.index') }}" class="btn btn-outline-secondary">
                            إلغاء
                        </a><button class="btn btn-primary-custom">
                            <i class="bi bi-arrow-left-right ms-1"></i> تنفيذ النقل
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
const students = @json($students);

const searchInput = document.getElementById('student_search');
const resultsBox  = document.getElementById('student_results');
const hiddenId    = document.getElementById('student_id');

searchInput.addEventListener('input', function () {
    const term = this.value.trim().toLowerCase();
    resultsBox.innerHTML = '';
    hiddenId.value = '';

    if (term.length < 1) {
        resultsBox.style.display = 'none';
        return;
    }

    const filtered = students.filter(s =>
        (s.full_name || '').toLowerCase().includes(term)
    ).slice(0, 8);

    if (!filtered.length) {
        resultsBox.style.display = 'none';
        return;
    }

    filtered.forEach(s => {
        const item = document.createElement('button');
        item.type = 'button';
        item.className = 'list-group-item list-group-item-action text-end';

        item.innerHTML = `
            <div class="fw-semibold">${s.full_name}</div>
            <div class="small text-muted">${s.grade?.name ?? ''} - ${s.section?.name ?? ''}</div>
        `;

        item.onclick = () => {
            searchInput.value = s.full_name;
            hiddenId.value = s.id;
            resultsBox.style.display = 'none';
        };

        resultsBox.appendChild(item);
    });

    resultsBox.style.display = 'block';
});

document.addEventListener('click', e => {
    if (!e.target.closest('.position-relative')) {
        resultsBox.style.display = 'none';
    }
});
</script>

@endsection