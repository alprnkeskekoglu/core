<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-10">
            <a class="font-w600 text-white tracking-wide" href="">
                <span class="smini-visible">
                    D<span class="opacity-75">S</span>
                </span>
                <span class="smini-hidden">
                    Dawn<span class="opacity-75">star</span>
                </span>
            </a>

            <div>
                <button type="button" class="btn btn-dual mr-1" data-toggle="layout" data-action="sidebar_mini_toggle">
                    <i class="fa fa-fw fa-bars"></i>
                </button>
                <a class="d-lg-none text-white ml-2" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
                    <i class="fa fa-times-circle"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="js-sidebar-scroll">
        <div class="content-side">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link active" href="{{ route('dawnstar.dashboard') }}">
                        <i class="nav-main-link-icon fa fa-rocket"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::dashboard.index_title') }}</span>
                        <span class="nav-main-link-badge badge badge-pill badge-success">3</span>
                    </a>
                </li>
                <li class="nav-main-heading">Base</li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.websites.index') }}">
                        <i class="nav-main-link-icon fa fa-desktop"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::website.index_title') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.containers.structures.index') }}">
                        <i class="nav-main-link-icon fa fa-cogs"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::container.index_title') }}</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.admins.index') }}">
                        <i class="nav-main-link-icon fa fa-user-lock"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::admin.index_title') }}</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.menus.index') }}">
                        <i class="nav-main-link-icon fa fa-stream"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::menu.index_title') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.forms.index') }}">
                        <i class="nav-main-link-icon fa fa-envelope-open-text"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::form.index_title') }}</span>
                    </a>
                </li>
                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.filemanager.index') }}">
                        <i class="nav-main-link-icon fa fa-file-upload"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::general.filemanager') }}</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a class="nav-main-link" href="{{ route('dawnstar.custom_contents.index') }}">
                        <i class="nav-main-link-icon fa fa-language"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::custom_content.index_title') }}</span>
                    </a>
                </li>


                <li class="nav-main-heading">{{ __('DawnstarLang::general.content') }}</li>

                <li class="nav-main-item">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true" aria-expanded="false" href="#">
                        <i class="nav-main-link-icon fa fa-puzzle-piece"></i>
                        <span class="nav-main-link-name">{{ __('DawnstarLang::general.pages') }}</span>
                    </a>
                    <ul class="nav-main-submenu">
                        @foreach(dawnstarMenu() as $menu)
                            <li class="nav-main-item">
                                <a class="nav-main-link" href="{{ $menu['url'] }}">
                                    <span class="nav-main-link-name">{{ $menu['name'] }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
