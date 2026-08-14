<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <title>

        @yield('title', 'EnterpriseHub')

    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

</head>

<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">

<div class="app-wrapper">

    @include('layouts.navbar')

    @include('layouts.sidebar')

    <main class="app-main">

        @include('layouts.breadcrumb')

        <div class="app-content">

            <div class="container-fluid">

                @include('layouts.partials.alert')

                @yield('content')

            </div>

        </div>

    </main>

    @include('layouts.footer')

</div>

@stack('scripts')

</body>

</html>