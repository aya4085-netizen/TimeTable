<aside class="sidebar d-flex flex-column justify-content-between p-3">

    {{-- Profile --}}
    <div>
        <div class="d-flex flex-column align-items-center mb-4 mt-2">
            <div class="profile-circle mb-2">
                <i class="bi bi-person-badge"></i>
            </div>

            <div class="fw-semibold">المعلم</div>
            <div class="small text-muted mt-1">
                {{ auth()->user()->name ?? '' }}
            </div>
        </div>

        {{-- Nav --}}
        <nav class="nav flex-column">

            <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('teacher.timetable') ? 'active' : '' }}"
               href="{{ route('teacher.timetable') }}">
                <i class="bi bi-calendar3"></i>
                <span>جدولي</span>
            </a>

            <a class="nav-link d-flex align-items-center gap-2 {{ request()->routeIs('teacher.change_requests.*') ? 'active' : '' }}"
               href="{{ route('teacher.change_requests.index') }}">
                <i class="bi bi-send"></i>
                <span>طلبات التغيير</span>
            </a>

        </nav>
    </div>

    {{-- Footer --}}
    <div class="mt-3">
    <hr class="my-2">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                    class="nav-link d-flex align-items-center gap-2 border-0 bg-transparent w-100">
                <i class="bi bi-box-arrow-left"></i>
                <span>تسجيل الخروج</span>
            </button>
        </form>
    </div>

</aside>
