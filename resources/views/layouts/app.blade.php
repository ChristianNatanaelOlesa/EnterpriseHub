<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', config('app.name', 'EnterpriseHub'))
    </title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


    <style>

        :root {

            --eh-top: 58px;
            --eh-side: 250px;
            --eh-border: #dee2e6;
            --eh-bg: #f5f7fa;

        }


        body {

            margin: 0;
            background: var(--eh-bg);

        }


        /* =========================================================
           TOPBAR
        ========================================================= */

        .eh-topbar {

            position: fixed;

            z-index: 1030;

            inset: 0 0 auto 0;

            height: var(--eh-top);

            background: #fff;

            border-bottom: 1px solid var(--eh-border);

            display: flex;

            align-items: center;

        }


        .eh-brand {

            width: var(--eh-side);

            height: 100%;

            padding: 0 1rem;

            display: flex;

            align-items: center;

            gap: .6rem;

            border-right: 1px solid var(--eh-border);

            text-decoration: none;

            color: #212529;

            font-weight: 700;

        }


        .eh-brand-mark {

            width: 32px;

            height: 32px;

            border-radius: 8px;

            display: inline-flex;

            align-items: center;

            justify-content: center;

            background: #198754;

            color: #fff;

        }


        .eh-top-nav {

            display: flex;

            align-items: center;

            gap: .15rem;

            padding-left: .65rem;

        }


        .eh-top-nav .nav-link {

            color: #343a40;

            text-decoration: none;

            padding: .55rem .8rem;

            border-radius: 6px;

            font-size: .9rem;

        }


        .eh-top-nav .nav-link:hover {

            background: #f1f3f5;

            color: #0d6efd;

        }


        .eh-user {

            margin-left: auto;

            margin-right: .75rem;

        }


        /* =========================================================
           SIDEBAR
        ========================================================= */

        .eh-sidebar {

            position: fixed;

            z-index: 1020;

            top: var(--eh-top);

            bottom: 0;

            left: 0;

            width: var(--eh-side);

            overflow-y: auto;

            background: #fff;

            border-right: 1px solid var(--eh-border);

        }


        .eh-sidebar-title {

            padding: 1rem 1rem .45rem;

            color: #6c757d;

            font-size: .72rem;

            font-weight: 700;

            text-transform: uppercase;

        }


        .eh-sidebar-menu {

            padding: .2rem .65rem 1rem;

        }


        .eh-sidebar-menu a {

            display: flex;

            align-items: center;

            gap: .65rem;

            padding: .6rem .75rem;

            margin-bottom: .15rem;

            border-radius: 7px;

            color: #495057;

            text-decoration: none;

            font-size: .9rem;

        }


        .eh-sidebar-menu a:hover,
        .eh-sidebar-menu a.active {

            background: #eaf2ff;

            color: #0d6efd;

        }


        /* =========================================================
           SIDEBAR GROUP
        ========================================================= */

        .eh-sidebar-group > .eh-sidebar-parent {

            display: flex;

            align-items: center;

            gap: .65rem;

            cursor: pointer;

        }


        .eh-sidebar-group > .eh-sidebar-parent > span {

            flex: 1;

        }


        .eh-sidebar-chevron {

            transition: transform .2s ease;

        }


        .eh-sidebar-group.is-open > .eh-sidebar-parent .eh-sidebar-chevron {

            transform: rotate(180deg);

        }


        .eh-sidebar-group .eh-sidebar-children {

            display: none;

            padding-left: 1rem;

        }


        .eh-sidebar-group.is-open > .eh-sidebar-children {

            display: block;

        }


        .eh-sidebar-group .eh-sidebar-children a {

            font-size: .86rem;

        }


        /* =========================================================
           TOP DROPDOWNS
        ========================================================= */

        .eh-top-dropdown {

            min-width: 220px;

            padding: .45rem;

            border: 1px solid #e2e8f0;

            border-radius: 12px;

            background: #ffffff;

            box-shadow: 0 12px 30px rgba(15, 23, 42, .12);

        }


        .eh-top-dropdown > li > .dropdown-item {

            border-radius: 8px;

            padding: .58rem .7rem;

        }


        .eh-top-dropdown > li > .dropdown-item:hover,
        .eh-top-dropdown > li > .dropdown-item:focus {

            background: #f1f5f9;

            color: #0f172a;

        }


        /* =========================================================
           CONTENT
        ========================================================= */

        .eh-content {

            min-height: 100vh;

            margin-left: var(--eh-side);

            padding-top: var(--eh-top);

        }


        .eh-content-inner {

            padding: 1.25rem;

        }


        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 991.98px) {

            .eh-brand {

                width: auto;

                border-right: 0;

            }


            .eh-top-nav {

                display: none;

            }


            .eh-sidebar {

                transform: translateX(-100%);

                transition: transform .2s ease;

            }


            .eh-sidebar.show {

                transform: translateX(0);

            }


            .eh-content {

                margin-left: 0;

            }

        }

    </style>


    @stack('styles')

</head>


<body>

<div class="eh-toast-container"
     id="ehToastContainer"
     aria-live="polite"
     aria-atomic="true"></div>


@include('layouts.navbar')

@include('layouts.sidebar')


<main class="eh-content">

    <div class="eh-content-inner">

        @yield('content')

    </div>

</main>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       MOBILE SIDEBAR
    ========================================================= */

    const button = document.getElementById('ehSidebarToggle');

    const sidebar = document.getElementById('ehSidebar');


    if (button && sidebar) {

        button.addEventListener('click', function () {

            sidebar.classList.toggle('show');

        });

    }


    /* =========================================================
       SIDEBAR PARENT TOGGLE
    ========================================================= */

    document.querySelectorAll('[data-sidebar-toggle]').forEach(function (toggle) {

        toggle.addEventListener('click', function (event) {

            event.preventDefault();

            const group = this.closest('.eh-sidebar-group');

            if (!group) {
                return;
            }

            const isOpen = group.classList.contains('is-open');


            /*
             * Kalau sedang terbuka → tutup.
             */
            if (isOpen) {

                group.classList.remove('is-open');

                this.setAttribute(
                    'aria-expanded',
                    'false'
                );

            }


            /*
             * Kalau sedang tertutup → buka.
             */
            else {

                group.classList.add('is-open');

                this.setAttribute(
                    'aria-expanded',
                    'true'
                );

            }

        });

    }


    /* =========================================================
       FLASH MESSAGE / TOAST
    ========================================================= */

    const toastContainer =
        document.getElementById('ehToastContainer');


    if (toastContainer) {

        document
            .querySelectorAll('.alert.alert-success, .alert.alert-danger')
            .forEach(function (alert) {

                /*
                 * Validation alert yang mempunyai <ul>
                 * tetap ditampilkan inline.
                 */
                if (
                    alert.classList.contains('alert-danger')
                    && alert.querySelector('ul')
                ) {

                    return;

                }


                alert.classList.remove(
                    'fade',
                    'show'
                );

                alert.classList.add('eh-toast');

                alert.setAttribute(
                    'role',
                    'alert'
                );


                toastContainer.appendChild(alert);


                requestAnimationFrame(function () {

                    alert.classList.add('show');

                });


                const closeButton =
                    alert.querySelector(
                        '[data-bs-dismiss="alert"]'
                    );


                if (closeButton) {

                    closeButton.addEventListener(
                        'click',
                        function () {

                            alert.classList.remove('show');

                            setTimeout(function () {

                                alert.remove();

                            }, 180);

                        }
                    );

                }


                setTimeout(function () {

                    if (!alert.isConnected) {
                        return;
                    }


                    alert.classList.remove('show');


                    setTimeout(function () {

                        alert.remove();

                    }, 180);

                }, 4500);

            });

    }

});

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | CLEAR EMPLOYEE EQUIPMENT SELECTION ON LOGOUT
    |--------------------------------------------------------------------------
    |
    | Selected Asset disimpan sementara di sessionStorage browser.
    | Saat user logout, state tersebut harus dibersihkan supaya
    | tidak terbawa ke user berikutnya.
    |
    */

    const logoutForms = document.querySelectorAll(
        'form[action="{{ route('logout') }}"]'
    );

    logoutForms.forEach(function (form) {

        form.addEventListener('submit', function () {

            sessionStorage.removeItem(
                'employeeEquipmentSelectedAssets'
            );

        });

    });

});
</script>


@stack('scripts')


</body>

</html>