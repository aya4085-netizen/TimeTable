<aside class="sidebar d-flex flex-column justify-content-between p-3">
    <div>

        {{-- معلومات الطالب --}}
        

        <div class="d-flex flex-column align-items-center mb-4 mt-2">
            <div class="profile-circle mb-2">
                <i class="bi bi-person"></i>
            </div>
            @php
    $student = \App\Models\Student::where('user_id', auth()->id())->first();
@endphp

<div class="fw-semibold">
    {{ $student->full_name ?? auth()->user()->name }}
</div>
<div class="small text-muted">
    طالب
</div>


        </div>

        {{-- الروابط --}}
        <nav class="nav flex-column">

            <a class="nav-link {{ request()->is('student/dashboard') ? 'active' : '' }}"
               href="{{ route('student.dashboard') }}">
                <i class="bi bi-calendar-week"></i>
                جدولي الدراسي
            </a>


        </nav>
    </div>

    {{-- تسجيل الخروج --}}
    <div class="mt-3">
    <hr class="my-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link d-flex align-items-center border-0 bg-transparent w-100"
                    type="submit">
                <i class="bi bi-box-arrow-left"></i>
                تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
