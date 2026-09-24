<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Authentication') - EnterpriseHub</title>

    @vite(['resources/css/app.css'])

    <style>
        :root {
            --eh-auth-primary: #0d6efd;
            --eh-auth-primary-dark: #0b5ed7;
            --eh-auth-bg: #f4f7fb;
            --eh-auth-text: #172033;
            --eh-auth-muted: #667085;
            --eh-auth-border: #dfe5ec;
        }

        body.eh-auth-page {
            min-height: 100vh;
            margin: 0;
            background: var(--eh-auth-bg);
            color: var(--eh-auth-text);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .eh-auth-shell {
            width: 100%;
            max-width: 430px;
        }

        .eh-auth-brand {
            text-align: center;
            margin-bottom: 1.25rem;
        }

        .eh-auth-brand-mark {
            width: 46px;
            height: 46px;
            margin: 0 auto .75rem;
            border-radius: 12px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--eh-auth-primary);
            color: #fff;
            font-size: 1.35rem;
            box-shadow: 0 8px 20px rgba(13, 110, 253, .18);
        }

        .eh-auth-brand-name {
            margin: 0;
            font-size: 1.45rem;
            font-weight: 700;
            letter-spacing: -.02em;
        }

        .eh-auth-brand-name span {
            font-weight: 400;
        }

        .eh-auth-card {
            border: 1px solid var(--eh-auth-border);
            border-radius: 10px;
            background: #fff;
            box-shadow: 0 12px 35px rgba(16, 24, 40, .08);
            overflow: hidden;
        }

        .eh-auth-card-body {
            padding: 1.65rem;
        }

        .eh-auth-title {
            margin-bottom: .35rem;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .eh-auth-subtitle {
            margin-bottom: 1.35rem;
            color: var(--eh-auth-muted);
            font-size: .9rem;
        }

        .eh-auth-input .input-group-text {
            min-width: 42px;
            justify-content: center;
            background: #fff;
            border-color: var(--eh-auth-border);
            color: #667085;
        }

        .eh-auth-input .form-control {
            min-height: 44px;
            border-color: var(--eh-auth-border);
        }

        .eh-auth-input .form-control:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .2rem rgba(13, 110, 253, .12);
        }

        .eh-auth-btn {
            min-height: 44px;
            font-weight: 600;
        }

        .eh-auth-links {
            margin-top: 1rem;
            text-align: center;
            font-size: .9rem;
        }

        .eh-auth-links a {
            color: var(--eh-auth-primary);
            text-decoration: none;
        }

        .eh-auth-links a:hover {
            text-decoration: underline;
        }

        .eh-demo-box {
            margin-top: 1.25rem;
            padding: 1rem;
            border: 1px solid #d9e7fb;
            border-radius: 8px;
            background: #f7fbff;
        }

        .eh-demo-box-title {
            margin-bottom: .65rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #526071;
        }

        .eh-demo-table {
            margin: 0;
            font-size: .88rem;
        }

        .eh-demo-table th {
            font-weight: 600;
            color: #475467;
            background: #eef5ff;
        }

        .eh-demo-table th,
        .eh-demo-table td {
            padding: .55rem .65rem;
            border-color: #dfe8f4;
        }

        .eh-auth-footer {
            margin-top: 1rem;
            text-align: center;
            color: #98a2b3;
            font-size: .78rem;
        }

        .eh-auth-alert {
            margin-bottom: 1rem;
            border-radius: 8px;
            font-size: .88rem;
        }
    </style>

    @stack('styles')
</head>
<body class="eh-auth-page" data-bs-theme="light">
    <main class="eh-auth-shell">
        <div class="eh-auth-brand">
            <div class="eh-auth-brand-mark">
                <i class="bi bi-buildings"></i>
            </div>
            <h1 class="eh-auth-brand-name">Enterprise<span>Hub</span></h1>
        </div>

        @yield('content')

        <div class="eh-auth-footer">
            EnterpriseHub &middot; Enterprise Management Platform
        </div>
    </main>
</body>
</html>
