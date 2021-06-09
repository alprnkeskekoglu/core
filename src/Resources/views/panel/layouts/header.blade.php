@php
    $websites = \Dawnstar\Models\Website::where('id', '<>', session('dawnstar.website.id'))->get();
@endphp


<header id="page-header">
    <div class="content-header justify-content-end">
        <div>
            @if($websites->isNotEmpty())
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-dual" id="website-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! session('dawnstar.website.slug') !!}
                        <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="website-dropdown" style="min-width: auto">
                        <div class="p-2">
                            @foreach($websites as $website)
                                <a class="dropdown-item" href="{{ route('dawnstar.panel.changeWebsite', ['id' => $website->id]) }}">
                                    {{ $website->slug }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <div class="dropdown d-inline-block">
                <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block">{{ auth('admin')->user()->username }}</span>
                    <i class="fa fa-fw fa-angle-down ml-1 d-none d-sm-inline-block"></i>
                </button>


                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="page-header-user-dropdown">
                    <div class="p-2">
                        <a class="dropdown-item" href="{{ route('dawnstar.profiles.edit') }}">
                            <i class="far fa-fw fa-user mr-1"></i> {{ __('DawnstarLang::profile.index_title') }}
                        </a>
                        <div role="separator" class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('dawnstar.tools.index') }}" data-toggle="layout" data-action="side_overlay_toggle">
                            <i class="far fa-fw fa-building mr-1"></i> {{ __('DawnstarLang::tool.index_title') }}
                        </a>

                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('dawnstar.auth.logout') }}">
                            <i class="far fa-fw fa-arrow-alt-circle-left mr-1"></i> {{ __('DawnstarLang::auth.log_out') }}
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
