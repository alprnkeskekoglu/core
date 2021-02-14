<header id="page-header">
    <div class="content-header justify-content-end">
        <div>
            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{ auth('admin')->user()->username }}</span>
                    <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                    <div class="bg-primary rounded-top font-w600 text-white text-center p-3">
                        User Options
                    </div>
                    <div class="p-2">
                        <a class="dropdown-item" href="{{ route('dawnstar.profile.index') }}">
                            <i class="far fa-fw fa-user mr-1"></i> Profile
                        </a>
                        <div role="separator" class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('dawnstar.tool.index') }}" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="far fa-fw fa-building mr-1"></i> {{ __('DawnstarLang::tool.index_title') }}
                        </a>

                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('dawnstar.auth.logout') }}">
                            <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> Sign Out
                        </a>
                    </div>
                </div>
            </div>

            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="language-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-globe-europe"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="language-dropdown" style="min-width: auto">
                    <div class="p-2">
                        @if(session('dawnstar.language.code') == 'tr')
                            <a class="dropdown-item" href="{{ route('dawnstar.panel.changeLanguage', ['code' => 'en']) }}">
                                EN
                            </a>
                        @else
                            <a class="dropdown-item" href="{{ route('dawnstar.panel.changeLanguage', ['code' => 'tr']) }}">
                                TR
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="page-header-loader" class="overlay-header bg-primary-darker">
        <div class="content-header">
            <div class="w-100 text-center">
                <i class="fa fa-fw fa-2x fa-sun fa-spin text-white"></i>
            </div>
        </div>
    </div>
</header>
