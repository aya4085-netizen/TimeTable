@extends('layout.app')

@section('title','ترحيل الطلبة')

@section('content')

<h1 class="main-title">ترحيل الطلبة </h1>

@if(session('error'))
  <div class="alert alert-danger">{{ session('error') }}</div>
@endif
@if(session('success'))
  <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card card-soft">
  <div class="card-body">

    <form method="POST" action="{{ route('registrar.moves.promote.store') }}" class="row g-3">
      @csrf

      {{-- من (الصف/الفصل) --}}
      <div class="col-12">
        <div class="fw-bold mb-2">من</div>
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label">الصف الحالي</label>
        <select name="from_grade_id" id="from_grade_id" class="form-select" required>
          <option value="">اختر الصف...</option>
          @foreach($grades as $g)
            <option value="{{ $g->id }}" {{ old('from_grade_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>
          @endforeach
        </select>
      
      {{-- إلى (الصف/الفصل) --}}
      <div class="col-12 mt-3">
        <div class="fw-bold mb-2">إلى</div>
      </div>

      <div class="col-12 col-md-4">
        <label class="form-label">الصف القادم</label>
        <select name="to_grade_id" id="to_grade_id" class="form-select" required>
          <option value="">اختر الصف...</option>
          @foreach($grades as $g)
            <option value="{{ $g->id }}" {{ old('to_grade_id')==$g->id?'selected':'' }}>{{ $g->name }}</option>
          @endforeach
        </select>
      </div>


      
      <div class="col-12 d-flex gap-2 mt-2">
        <button class="btn btn-primary-custom">
          <i class="bi bi-arrow-up-circle ms-1"></i> تنفيذ الترحيل
        </button>

        <a href="{{ route('registrar.students.index') }}" class="btn btn-outline-secondary">رجوع</a>
      </div>
    </form>

  </div>
</div>

{{-- فلترة الفصول حسب الصف (من/إلى) --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  const fromGrade = document.getElementById('from_grade_id');
  const fromSec   = document.getElementById('from_section_id');
  const toGrade   = document.getElementById('to_grade_id');
  const toSec     = document.getElementById('to_section_id');

  function filter(selectGrade, selectSection) {
    const gid = selectGrade.value;
    Array.from(selectSection.options).forEach(opt => {
      if (!opt.value) return; // "الكل" أو "اختر"
      const og = opt.getAttribute('data-grade');
      opt.hidden = (gid && og !== gid);
    });
    const selected = selectSection.options[selectSection.selectedIndex];
    if (selected && selected.hidden) selectSection.value = '';
  }
  fromGrade.addEventListener('change', ()=>filter(fromGrade, fromSec));
  toGrade.addEventListener('change', ()=>filter(toGrade, toSec));

  filter(fromGrade, fromSec);
  filter(toGrade, toSec);
});
</script>

@endsection