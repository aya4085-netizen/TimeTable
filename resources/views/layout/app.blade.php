<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title','لوحة التحكم')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary-color: #b04393;
            --sidebar-bg: #e0e0e0;
            --card-bg: #f2f2f2;
        }
        body { font-family: "Tajawal", system-ui, -apple-system, "Segoe UI", sans-serif; background:#fff; }
        .sidebar { background: var(--sidebar-bg); width: 260px; }
        .profile-circle { width:80px;height:80px;border-radius:50%;background:#d0cfd4;display:flex;align-items:center;justify-content:center;font-size:40px;color:#6b6280; }
        .sidebar .nav-link { color:#333;font-size:15px;padding:10px 16px;border-radius:999px;margin-bottom:6px; }
        .sidebar .nav-link i { color: var(--primary-color); margin-left:8px;font-size:18px; }
        .sidebar .nav-link.active, .sidebar .nav-link:hover { background:#fff; }
        .main-title { font-size:30px;font-weight:700;margin-bottom:24px; }
        .card-soft { background: var(--card-bg); border:none; border-radius:10px; }
        .btn-primary-custom { background: var(--primary-color); border-color: var(--primary-color); }
        .btn-primary-custom:hover { background:#8e347b; border-color:#8e347b; }
        .action-icon { color: var(--primary-color); font-size:18px; }
        .action-icon.btn-link { text-decoration:none; }
        .form-control:focus { box-shadow:none; border-color: var(--primary-color); }
        .search-input { max-width:260px; }
        @media (max-width: 768px){ .sidebar{width:220px;} .main-title{font-size:24px;} }
    </style>
</head>
<body>

<div class="d-flex flex-row min-vh-100" style="direction: rtl;">

    {{-- Sidebar حسب الدور --}}
    @auth
        @php $role = auth()->user()->role; @endphp

        @if($role === 'supervisor')
            @include('layout.sidebars.supervisor')
        @elseif($role === 'teacher')
            @include('layout.sidebars.teacher')
        @elseif($role === 'student')
            @include('layout.sidebars.student')
        @elseif($role === 'registrar')
            @include('layout.sidebars.registrar')
        @else
            @include('layout.sidebars.default')
        @endif
    @endauth

    <main class="flex-grow-1 p-4">
        @yield('content')
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
