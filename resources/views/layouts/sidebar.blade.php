@php
    $sidebarMenuTree = \App\Support\Permission::sidebarMenuTree();
    $sidebarMenus = $sidebarMenuTree->get(null, collect());
@endphp

<aside id="ehSidebar"
       class="eh-sidebar">

    <div class="eh-sidebar-title">
        My Workspace
    </div>

    <nav class="eh-sidebar-menu">

        @include('layouts.partials.sidebar-menu', [
            'menus' => $sidebarMenus,
            'menuTree' => $sidebarMenuTree,
        ])

    </nav>

</aside>