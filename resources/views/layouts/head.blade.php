<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>
    @yield('title', 'EnterpriseHub')
</title>

@vite([
    'resources/css/app.css',
    'resources/js/app.js'
])

@stack('styles')