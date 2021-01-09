<!-- Sidebar -->
<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <!-- Logo -->
            <a class="font-w600 text-white tracking-wide" href="">
                            <span class="smini-visible">
                                D<span class="opacity-75">x</span>
                            </span>
                <span class="smini-hidden">
                                Dash<span class="opacity-75">mix</span>
                            </span>
            </a>
            <!-- END Logo -->

            <!-- Options -->
            <div>

                <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_mini_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
                <!-- END Close Sidebar -->
            </div>
            <!-- END Options -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="gs_backend.html">
                        <i class="nav-main-link-icon fa fa-rocket"></i>
                        <span class="nav-main-link-name">Dashboard</span>
                        <span class="nav-main-link-badge badge badge-pill badge-success">3</span>
                    </a>
                </li>
                <li class="nav-main-heading">Heading</li>
                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-puzzle-piece"></i>
                        <span class="nav-main-link-name">Dropdown</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="javascript:void(0)">
                                <span class="nav-main-link-name">Link #1</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link" href="javascript:void(0)">
                                <span class="nav-main-link-name">Link #2</span>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.admin.index') }}">
                        <span class="nav-main-link-name">Admin</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.form.index') }}">
                        <span class="nav-main-link-name">Form</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.menu.index') }}">
                        <span class="nav-main-link-name">Menu</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.website.index') }}">
                        <span class="nav-main-link-name">Website</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.custom_content.index') }}">
                        <span class="nav-main-link-name">Custom Content</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.container.structure.index') }}">
                        <span class="nav-main-link-name">Container</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- END Sidebar Scrolling -->
</nav>
<!-- END Sidebar -->
