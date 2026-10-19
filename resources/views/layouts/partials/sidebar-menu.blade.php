@foreach ($menus as $menu)
    @php
        $children = $menuTree->get($menu->MenuID, collect());

        $isActive = \App\Support\Permission::isMenuActive($menu->Route);

        $hasActiveChild = false;

        foreach ($children as $child) {
            if (\App\Support\Permission::isMenuActive($child->Route)) {
                $hasActiveChild = true;
                break;
            }
        }

        // Parent otomatis terbuka jika route parent atau child aktif.
        $isOpen = $isActive || $hasActiveChild;

        $url = '#';

        if ($menu->Route && \Illuminate\Support\Facades\Route::has($menu->Route)) {
            $url = route($menu->Route);
        }
    @endphp

    @if ($children->isEmpty())
        <a href="{{ $url }}" class="{{ $isActive ? 'active' : '' }}">
            @if ($menu->Icon)
                <i class="{{ $menu->Icon }}"></i>
            @endif
            <span>{{ $menu->Menu }}</span>
        </a>
    @else
        <div class="eh-sidebar-group {{ $isOpen ? 'is-open' : '' }}">
            <a href="#" class="eh-sidebar-parent {{ $hasActiveChild ? 'active' : '' }}" data-sidebar-toggle
                aria-expanded="{{ $isOpen ? 'true' : 'false' }}">
                @if ($menu->Icon)
                    <i class="{{ $menu->Icon }}"></i>
                @endif

                <span>{{ $menu->Menu }}</span>
                <i class="bi bi-chevron-down ms-auto eh-sidebar-chevron"></i>
            </a>

            <div class="eh-sidebar-children">
                @include('layouts.partials.sidebar-menu', [
                    'menus' => $children,
                    'menuTree' => $menuTree,
                ])
            </div>
        </div>
    @endif
@endforeach

@once
    @push('styles')
        <style>
            .eh-sidebar-group {
                width: 100%;
            }

            .eh-sidebar-group>.eh-sidebar-parent {
                display: flex;
                align-items: center;
                gap: .65rem;
                cursor: pointer;
            }

            .eh-sidebar-group>.eh-sidebar-parent>span {
                flex: 1;
            }

            .eh-sidebar-chevron {
                transition: transform .2s ease;
            }

            .eh-sidebar-group.is-open>.eh-sidebar-parent .eh-sidebar-chevron {
                transform: rotate(180deg);
            }

            .eh-sidebar-group>.eh-sidebar-children {
                display: none;
                padding-left: 1rem;
            }

            .eh-sidebar-group.is-open>.eh-sidebar-children {
                display: block;
            }

            .eh-sidebar-group .eh-sidebar-children a {
                font-size: .86rem;
            }
        </style>
    @endpush
@endonce
