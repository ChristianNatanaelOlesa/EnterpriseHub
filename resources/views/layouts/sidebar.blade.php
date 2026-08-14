<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">

    <div class="sidebar-brand">

        <a href="{{ route('dashboard') }}" class="brand-link">

            <span class="brand-text fw-semibold">

                EnterpriseHub

            </span>

        </a>

    </div>

    <div class="sidebar-wrapper">

        <nav class="mt-2">

            <ul class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="menu"
                data-accordion="false">

                <li class="nav-item">

                    <a href="{{ route('dashboard') }}"
                       class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                        <i class="nav-icon bi bi-speedometer2"></i>

                        <p>

                            Dashboard

                        </p>

                    </a>

                </li>

                <li class="nav-header">

                    MASTER

                </li>

                <li class="nav-item">

                    <a href="#"
                       class="nav-link">

                        <i class="nav-icon bi bi-building"></i>

                        <p>

                            Master

                            <i class="nav-arrow bi bi-chevron-right"></i>

                        </p>

                    </a>

                    <ul class="nav nav-treeview">

                        <li class="nav-item">

                            <a href="{{ route('master.company.index') }}"
                               class="nav-link {{ request()->routeIs('master.company.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-circle"></i>

                                <p>

                                    Company

                                </p>

                            </a>

                        </li>

                        <li class="nav-item">

                            <a href="{{ route('security.users.index')}}"
                            class="nav-link {{ request()->routeIs('security.users.*') ? 'active' : '' }}">

                                <i class="nav-icon bi bi-people"></i>

                                <p>

                                    Users

                                </p>

                            </a>

                        </li>

                    </ul>

                </li>

            </ul>

        </nav>

    </div>

</aside>