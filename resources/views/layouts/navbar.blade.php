@php
    $topMenuTree = \App\Support\Permission::topMenuTree();
    $topMenus = $topMenuTree->get(null, collect());
@endphp

<header class="eh-topbar">

    <a href="{{ route('dashboard') }}" class="eh-brand">
        <span class="eh-brand-mark">EH</span>
        <span>EnterpriseHub</span>
    </a>

    <button id="ehSidebarToggle"
            type="button"
            class="btn btn-link d-lg-none text-dark ms-2">
        <i class="bi bi-list fs-4"></i>
    </button>

    <nav class="eh-top-nav">

        @foreach ($topMenus as $menu)

            @php
                $children = $topMenuTree->get($menu->MenuID, collect());

                $url = '#';

                if (
                    $menu->Route &&
                    \Illuminate\Support\Facades\Route::has($menu->Route)
                ) {
                    $url = route($menu->Route);
                } elseif ($menu->URL) {
                    $url = $menu->URL;
                }
            @endphp

            @if ($children->isEmpty())

                <a href="{{ $url }}"
                   class="nav-link {{ \App\Support\Permission::isMenuActive($menu->Route) ? 'active' : '' }}">

                    @if ($menu->Icon)
                        <i class="{{ $menu->Icon }} me-1"></i>
                    @endif

                    {{ $menu->Name }}

                </a>

            @else

                <div class="dropdown">

                    <a href="#"
                       class="nav-link dropdown-toggle"
                       data-bs-toggle="dropdown"
                       data-bs-auto-close="outside"
                       aria-expanded="false">

                        @if ($menu->Icon)
                            <i class="{{ $menu->Icon }} me-1"></i>
                        @endif

                        {{ $menu->Name }}

                    </a>

                    <ul class="dropdown-menu eh-top-dropdown">

                        @include('layouts.partials.top-menu', [
                            'menus' => $children,
                            'menuTree' => $topMenuTree,
                        ])

                    </ul>

                </div>

            @endif

        @endforeach

    </nav>

    <div class="eh-user">

        @auth
            <div class="dropdown">

                <a href="#"
                   class="text-decoration-none text-dark dropdown-toggle"
                   data-bs-toggle="dropdown">

                    <i class="bi bi-person-circle me-1"></i>

                    {{ auth()->user()->FullName
                        ?? auth()->user()->Name
                        ?? auth()->user()->username
                        ?? auth()->user()->UserID
                        ?? 'User' }}

                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <li>
                        <span class="dropdown-item-text text-muted">
                            Signed in
                        </span>
                    </li>

                    <li><hr class="dropdown-divider"></li>

                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="bi bi-box-arrow-right me-2"></i>
                                Logout
                            </button>
                        </form>
                    </li>

                </ul>

            </div>
        @else

            <a href="{{ route('login') }}"
               class="btn btn-sm btn-outline-primary">
                Login
            </a>

        @endauth

    </div>

</header>



@push('scripts')
<script>
(function () {

    function initEnterpriseHubMasterMenu() {

        document
            .querySelectorAll('[data-eh-master-toggle]')
            .forEach(function (button) {

                if (button.dataset.ehBound === '1') {
                    return;
                }

                button.dataset.ehBound = '1';

                button.addEventListener('click', function (event) {

                    event.preventDefault();
                    event.stopPropagation();

                    const wrapper =
                        this.closest('.eh-master-wrapper');

                    if (!wrapper) {
                        return;
                    }

                    const submenu =
                        wrapper.querySelector('.eh-master-submenu');

                    if (!submenu) {
                        return;
                    }

                    const isOpen =
                        submenu.classList.contains('is-open');

                    /*
                     * Tutup semua Master submenu lain.
                     */
                    document
                        .querySelectorAll('.eh-master-submenu.is-open')
                        .forEach(function (item) {

                            item.classList.remove('is-open');

                        });

                    document
                        .querySelectorAll('[data-eh-master-toggle].is-open')
                        .forEach(function (item) {

                            item.classList.remove('is-open');

                        });

                    /*
                     * Toggle submenu yang diklik.
                     */
                    if (!isOpen) {

                        submenu.classList.add('is-open');

                        this.classList.add('is-open');

                    }

                });

            });


        /*
         * Klik di luar Master submenu => tutup submenu.
         */
        document.addEventListener('click', function (event) {

            if (
                event.target.closest('.eh-master-wrapper')
            ) {
                return;
            }

            document
                .querySelectorAll('.eh-master-submenu.is-open')
                .forEach(function (item) {

                    item.classList.remove('is-open');

                });

            document
                .querySelectorAll('[data-eh-master-toggle].is-open')
                .forEach(function (item) {

                    item.classList.remove('is-open');

                });

        });

    }

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initEnterpriseHubMasterMenu
        );

    } else {

        initEnterpriseHubMasterMenu();

    }

})();
</script>
@endpush
