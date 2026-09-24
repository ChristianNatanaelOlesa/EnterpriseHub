@foreach ($menus as $menu)

    @php
        $children = $menuTree->get(
            $menu->MenuID,
            collect()
        );

        $isActive = \App\Support\Permission::isMenuActive(
            $menu->Route
        );

        $hasActiveChild = false;

        foreach ($children as $child) {

            if (
                \App\Support\Permission::isMenuActive(
                    $child->Route
                )
            ) {
                $hasActiveChild = true;
                break;
            }

        }

        /*
         * Parent otomatis terbuka kalau:
         * - parent sedang aktif
         * - salah satu child sedang aktif
         */
        $isOpen = $isActive || $hasActiveChild;


        /*
         * URL untuk menu biasa.
         */
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

        {{-- =====================================================
             SINGLE MENU
        ====================================================== --}}

        <a href="{{ $url }}"
           class="{{ $isActive ? 'active' : '' }}">

            @if ($menu->Icon)
                <i class="{{ $menu->Icon }}"></i>
            @endif

            <span>
                {{ $menu->Name }}
            </span>

        </a>


    @else

        {{-- =====================================================
             PARENT MENU
        ====================================================== --}}

        <div class="eh-sidebar-group {{ $isOpen ? 'is-open' : '' }}">

            <a href="#"
               class="eh-sidebar-parent {{ $hasActiveChild ? 'active' : '' }}"
               data-sidebar-toggle
               aria-expanded="{{ $isOpen ? 'true' : 'false' }}">

                @if ($menu->Icon)
                    <i class="{{ $menu->Icon }}"></i>
                @endif

                <span>
                    {{ $menu->Name }}
                </span>

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

            /* =====================================================
               SIDEBAR GROUP
            ====================================================== */

            .eh-sidebar-group {
                width: 100%;
            }


            /* =====================================================
               PARENT MENU
            ====================================================== */

            .eh-sidebar-group > .eh-sidebar-parent {

                display: flex;

                align-items: center;

                gap: .65rem;

                cursor: pointer;

            }


            .eh-sidebar-group > .eh-sidebar-parent > span {

                flex: 1;

            }


            /* =====================================================
               CHEVRON
            ====================================================== */

            .eh-sidebar-chevron {

                transition: transform .2s ease;

            }


            .eh-sidebar-group.is-open
            > .eh-sidebar-parent
            .eh-sidebar-chevron {

                transform: rotate(180deg);

            }


            /* =====================================================
               CHILDREN
            ====================================================== */

            .eh-sidebar-group
            > .eh-sidebar-children {

                display: none;

                padding-left: 1rem;

            }


            .eh-sidebar-group.is-open
            > .eh-sidebar-children {

                display: block;

            }


            /* =====================================================
               CHILD MENU
            ====================================================== */

            .eh-sidebar-group
            .eh-sidebar-children
            a {

                font-size: .86rem;

            }

        </style>

    @endpush


    @push('scripts')

        <script>

            document.addEventListener(
                'DOMContentLoaded',
                function () {

                    /*
                     * Cari semua parent sidebar.
                     */
                    document
                        .querySelectorAll('[data-sidebar-toggle]')
                        .forEach(function (toggle) {

                            toggle.addEventListener(
                                'click',
                                function (event) {

                                    event.preventDefault();
                                    event.stopPropagation();


                                    const group =
                                        this.closest(
                                            '.eh-sidebar-group'
                                        );


                                    if (!group) {
                                        return;
                                    }


                                    const isOpen =
                                        group.classList.contains(
                                            'is-open'
                                        );


                                    /*
                                     * Toggle parent yang diklik.
                                     */
                                    if (isOpen) {

                                        group.classList.remove(
                                            'is-open'
                                        );

                                        this.setAttribute(
                                            'aria-expanded',
                                            'false'
                                        );

                                    } else {

                                        group.classList.add(
                                            'is-open'
                                        );

                                        this.setAttribute(
                                            'aria-expanded',
                                            'true'
                                        );

                                    }

                                }
                            );

                        });

                }
            );

        </script>

    @endpush

@endonce