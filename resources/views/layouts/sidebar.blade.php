<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">

        <a href="{{ route('dashboard') }}" class="brand-link">

            <span class="brand-text fw-light">
                EnterpriseHub
            </span>

        </a>

    </div>

    <div class="sidebar-wrapper">

        @php
            $menuTree = \App\Support\Permission::menuTree();
            $rootMenus = $menuTree->get(null, collect());
        @endphp

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

                @include('layouts.partials.sidebar-menu', [
                    'menus' => $rootMenus,
                    'menuTree' => $menuTree,
                ])

            </ul>

        </nav>

    </div>

</aside>
