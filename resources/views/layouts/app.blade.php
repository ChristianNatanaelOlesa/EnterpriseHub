<!DOCTYPE html>
<html lang="en">

<head>

    @include('layouts.head')

</head>

<body>

    @include('layouts.navbar')

    <div class="container-fluid">

        <div class="row">

            <aside class="col-md-2 p-0">

                @include('layouts.sidebar')

            </aside>

            <main class="col-md-10 p-4">

                @include('layouts.breadcrumb')

                <x-alert />

                @yield('content')

            </main>

        </div>

    </div>

    @include('layouts.footer')

    @stack('scripts')

</body>

</html>