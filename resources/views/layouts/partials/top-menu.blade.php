@foreach ($menus as $menu)

    @php
        $children = $menuTree->get($menu->MenuID, collect());

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

        <li>
            <a class="dropdown-item"
               href="{{ $url }}">

                @if ($menu->Icon)
                    <i class="{{ $menu->Icon }} me-2"></i>
                @endif

                {{ $menu->Name }}

            </a>
        </li>

    @else

        <li class="eh-master-wrapper">

            <button type="button"
                    class="dropdown-item eh-master-toggle"
                    data-eh-master-toggle
                    aria-expanded="false">

                @if ($menu->Icon)
                    <i class="{{ $menu->Icon }} me-2"></i>
                @endif

                <span>{{ $menu->Name }}</span>

                <i class="bi bi-chevron-down eh-master-arrow"></i>

            </button>

            {{-- 
                IMPORTANT:
                Jangan menggunakan .dropdown-menu di level ini.
                Submenu dibuat static di bawah Master supaya tidak
                dipotong/ditimpa oleh positioning Bootstrap.
            --}}
            <div class="eh-master-submenu"
                 data-eh-master-submenu
                 style="display: none;">

                @foreach ($children as $child)

                    @php
                        $childChildren = $menuTree->get(
                            $child->MenuID,
                            collect()
                        );

                        $childUrl = '#';

                        if (
                            $child->Route &&
                            \Illuminate\Support\Facades\Route::has($child->Route)
                        ) {
                            $childUrl = route($child->Route);
                        } elseif ($child->URL) {
                            $childUrl = $child->URL;
                        }
                    @endphp

                    @if ($childChildren->isEmpty())

                        <a class="dropdown-item"
                           href="{{ $childUrl }}">

                            @if ($child->Icon)
                                <i class="{{ $child->Icon }} me-2"></i>
                            @endif

                            {{ $child->Name }}

                        </a>

                    @else

                        <div class="eh-master-category">
                            {{ $child->Name }}
                        </div>

                        @foreach ($childChildren as $grandChild)

                            @php
                                $grandChildUrl = '#';

                                if (
                                    $grandChild->Route &&
                                    \Illuminate\Support\Facades\Route::has($grandChild->Route)
                                ) {
                                    $grandChildUrl = route($grandChild->Route);
                                } elseif ($grandChild->URL) {
                                    $grandChildUrl = $grandChild->URL;
                                }
                            @endphp

                            <a class="dropdown-item"
                               href="{{ $grandChildUrl }}">

                                @if ($grandChild->Icon)
                                    <i class="{{ $grandChild->Icon }} me-2"></i>
                                @endif

                                {{ $grandChild->Name }}

                            </a>

                        @endforeach

                    @endif

                @endforeach

            </div>

        </li>

    @endif

@endforeach


@once

<style>
    /*
     * ================================================================
     * ENTERPRISEHUB MASTER DROPDOWN
     * ================================================================
     */

    .eh-master-wrapper {
        display: block !important;
        position: relative;
        width: 100%;
    }

    .eh-master-toggle {
        width: 100% !important;
        min-height: 42px;
        border: 0 !important;
        border-radius: 8px !important;
        background: transparent !important;
        text-align: left !important;
        cursor: pointer !important;
        display: flex !important;
        align-items: center !important;
        gap: .55rem;
        color: #1f2937 !important;
        font-weight: 600;
    }

    .eh-master-toggle:hover,
    .eh-master-toggle:focus,
    .eh-master-toggle.is-open {
        background: #f1f5f9 !important;
        color: #0f172a !important;
    }

    .eh-master-toggle > span {
        flex: 1 1 auto;
        min-width: 0;
    }

    .eh-master-arrow {
        margin-left: auto;
        font-size: .72rem;
        color: #64748b;
        transition: transform .15s ease;
    }

    .eh-master-toggle.is-open .eh-master-arrow {
        transform: rotate(180deg);
    }

    .eh-master-submenu {
        width: 100% !important;
        position: static !important;
        margin: .15rem 0 .35rem !important;
        padding: .2rem 0 .35rem !important;
        background: #f8fafc !important;
        border: 1px solid #e5e7eb !important;
        border-radius: 9px !important;
        box-shadow: none !important;
        overflow: hidden !important;
    }

    .eh-master-submenu .dropdown-item {
        display: flex;
        align-items: center;
        gap: .35rem;
        width: 100%;
        min-height: 36px;
        padding: .48rem .7rem .48rem 1.05rem !important;
        border-radius: 0 !important;
        white-space: nowrap;
        color: #475569 !important;
        font-size: .84rem;
        font-weight: 500;
        text-decoration: none;
    }

    .eh-master-submenu .dropdown-item:hover,
    .eh-master-submenu .dropdown-item:focus {
        background: #e8f1ff !important;
        color: #0d6efd !important;
    }

    .eh-master-submenu .dropdown-item i {
        width: 1.05rem;
        color: #64748b;
        text-align: center;
    }

    .eh-master-submenu .dropdown-item:hover i,
    .eh-master-submenu .dropdown-item:focus i {
        color: #0d6efd;
    }

    .eh-master-category {
        padding: .65rem .7rem .25rem 1.05rem;
        font-size: .66rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: .055em;
        color: #94a3b8;
    }

    .eh-master-category:first-child {
        padding-top: .35rem;
    }

    @media (min-width: 992px) {
        .eh-top-dropdown {
            min-width: 250px;
            padding: .5rem;
        }

        .eh-master-submenu {
            max-height: 70vh;
            overflow-y: auto !important;
        }
    }
</style>

<script>
(function () {

    /*
     * Event delegation.
     *
     * Kita sengaja tidak menggunakan Bootstrap untuk Master.
     * Submenu dibuka menggunakan inline style sehingga tidak mungkin
     * kalah oleh CSS Bootstrap / CSS lain.
     */

    document.addEventListener('click', function (event) {

        const button = event.target.closest(
            '[data-eh-master-toggle]'
        );

        if (!button) {
            return;
        }

        event.preventDefault();
        event.stopPropagation();

        const wrapper = button.closest(
            '.eh-master-wrapper'
        );

        if (!wrapper) {
            return;
        }

        const submenu = wrapper.querySelector(
            '[data-eh-master-submenu]'
        );

        if (!submenu) {
            return;
        }

        const currentlyOpen =
            button.getAttribute('aria-expanded') === 'true';


        /*
         * Tutup submenu Master lainnya.
         */
        document
            .querySelectorAll('[data-eh-master-submenu]')
            .forEach(function (item) {

                item.style.setProperty(
                    'display',
                    'none',
                    'important'
                );

            });


        document
            .querySelectorAll('[data-eh-master-toggle]')
            .forEach(function (item) {

                item.setAttribute(
                    'aria-expanded',
                    'false'
                );

                item.classList.remove(
                    'is-open'
                );

            });


        /*
         * Buka submenu yang diklik.
         */
        if (!currentlyOpen) {

            submenu.style.setProperty(
                'display',
                'block',
                'important'
            );

            button.setAttribute(
                'aria-expanded',
                'true'
            );

            button.classList.add(
                'is-open'
            );

        }

    }, true);

})();
</script>

@endonce
