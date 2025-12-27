<aside class="sidebar d-flex flex-column justify-content-between p-3">
    <div>
        <div class="d-flex flex-column align-items-center mb-4 mt-2">
            <div class="profile-circle mb-2"><i class="bi bi-person"></i></div>
            <div class="fw-semibold">مشرف أكاديمي</div>
        </div>

        <nav class="nav flex-column">
            <a class="nav-link {{ request()->is('supervisor/dashboard') ? 'active' : '' }}"
               href="{{ route('supervisor.dashboard') }}">
                <i class="bi bi-house-door"></i> لوحة التحكم
            </a>

            <a class="nav-link {{ request()->is('supervisor/users*') ? 'active' : '' }}"
               href="{{ route('supervisor.users.index') }}">
                <i class="bi bi-person-plus"></i> الحسابات
            </a>

            <a class="nav-link {{ request()->is('supervisor/teacher*') ? 'active' : '' }}"
               href="{{ route('teacher.index') }}">
                <i class="bi bi-people"></i> المعلمون
            </a>

            <a class="nav-link {{ request()->is('supervisor/subject*') ? 'active' : '' }}"
               href="{{ route('subject.index') }}">
                <i class="bi bi-journal-bookmark"></i> المواد
            </a>

            <a class="nav-link {{ request()->is('supervisor/grade*') ? 'active' : '' }}"
               href="{{ route('grade.index') }}">
                <i class="bi bi-collection"></i> الصفوف
            </a>

            <a class="nav-link {{ request()->is('supervisor/section*') ? 'active' : '' }}"
               href="{{ route('section.index') }}">
                <i class="bi bi-grid-3x3-gap"></i> الفصول
            </a>

            <a class="nav-link {{ request()->is('supervisor/timetable*') ? 'active' : '' }}"
               href="{{ route('timetable.index') }}">
                <i class="bi bi-calendar3"></i> الجدول الدراسي
            </a>
            <a class="nav-link {{ request()->is('supervisor/change-requests*') ? 'active' : '' }}"
   href="{{ route('change_requests.index') }}">
    <i class="bi bi-envelope-paper"></i> طلبات تغيير الجدول
</a>

            
        </nav>
    </div>

    <div class="mt-3">
    <hr class="my-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="nav-link d-flex align-items-center border-0 bg-transparent w-100" type="submit">
                <i class="bi bi-box-arrow-left"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
