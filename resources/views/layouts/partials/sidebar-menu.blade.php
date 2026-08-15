@foreach ($menus as $menu)
    @php

        $children = $menuTree->get($menu->MenuID, collect());

        $hasActiveChild = $children->contains(function ($child) use ($menuTree) {
            return \App\Support\Permission::hasActiveMenu($child, $menuTree);
        });

    @endphp


    {{-- MENU TANPA CHILD --}}

    @if ($children->isEmpty() && $menu->Route)
        <li class="nav-item">

            <a href="{{ route($menu->Route) }}"
                class="nav-link
                    {{ \App\Support\Permission::isMenuActive($menu->Route) ? 'active' : '' }}">

                <i class="nav-icon {{ $menu->Icon }}"></i>

                <p>
                    {{ $menu->Name }}
                </p>

            </a>

        </li>


        {{-- MENU DENGAN CHILD --}}
    @elseif ($children->isNotEmpty())
        <li class="nav-item
                {{ $hasActiveChild ? 'menu-open' : '' }}">

            <a href="#" class="nav-link
                    {{ $hasActiveChild ? 'active' : '' }}">

                <i class="nav-icon {{ $menu->Icon }}"></i>

                <p>

                    {{ $menu->Name }}

                    <i class="nav-arrow bi bi-chevron-right"></i>

                </p>

            </a>


            <ul class="nav nav-treeview">

                @include('layouts.partials.sidebar-menu', [
                    'menus' => $children,
                    'menuTree' => $menuTree,
                ])

            </ul>

        </li>
    @endif
@endforeach
