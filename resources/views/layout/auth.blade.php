<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','تسجيل الدخول')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root { --primary-color:#b04393; --card-bg:#f2f2f2; }
        body { font-family:"Tajawal",system-ui; background:#fff; }
        .card-soft{background:var(--card-bg);border:0;border-radius:10px;}
        .btn-primary-custom{background:var(--primary-color);border-color:var(--primary-color);}
        .btn-primary-custom:hover{background:#8e347b;border-color:#8e347b;}
        .form-control:focus{box-shadow:none;border-color:var(--primary-color);}
    </style>
</head>
<body>

<main class="min-vh-100 d-flex align-items-center justify-content-center p-3">
    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>