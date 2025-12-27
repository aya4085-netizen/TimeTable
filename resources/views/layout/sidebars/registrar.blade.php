<aside class="sidebar d-flex flex-column justify-content-between p-3">
    <div>
        {{-- Profile --}}
        <div class="d-flex flex-column align-items-center mb-4 mt-2">
            <div class="profile-circle mb-2">
                <i class="bi bi-person-lines-fill"></i>
            </div>
            <div class="fw-semibold">شؤون الطلبة</div>
            <div class="small text-muted mt-1">{{ auth()->user()->email ?? '' }}</div>
        </div>

        {{-- Nav --}}
        <nav class="nav flex-column">
            <a class="nav-link {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}"
               href="{{ route('registrar.dashboard') }}">
                <i class="bi bi-speedometer2"></i> لوحة التحكم
            </a>

            <a class="nav-link {{ request()->routeIs('registrar.students.*') ? 'active' : '' }}"
               href="{{ route('registrar.students.index') }}">
                <i class="bi bi-people"></i> الطلاب
            </a>
             {{-- نقل طالب --}}
           <a href="{{ route('registrar.moves.transfer.create') }}" class="nav-link">
    <i class="bi bi-arrow-left-right"></i> نقل طالب
</a>
<a class="nav-link {{ request()->routeIs('registrar.moves.promote.*') ? 'active' : '' }}"
               href="{{ route('registrar.moves.promote.create') }}">
                <i class="bi bi-arrow-up-circle"></i>
                ترحيل طالب
            </a>

           
        </nav>
    </div>

    {{-- Footer --}}
    <div class="mt-3">
        <hr class="my-2">

       

        <form action="{{ route('logout') }}" method="POST" class="m-0">
            @csrf
            <button class="nav-link d-flex align-items-center border-0 bg-transparent w-100 text-start" type="submit">
                <i class="bi bi-box-arrow-left"></i> تسجيل الخروج
            </button>
        </form>
    </div>
</aside>
