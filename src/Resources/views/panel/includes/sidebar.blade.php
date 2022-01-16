@php
    $containers = \Illuminate\Support\Facades\Cache::rememberForever('structures' . session('dawnstar.website.id') . session('dawnstar.language.id'), function() {
        return \Dawnstar\Core\Models\Container::whereHas('structure', function($q) {$q->active();})->with('translation')->get();
    });
@endphp
<div class="leftside-menu leftside-menu-detached">
    <div class="leftbar-user">
    </div>
    <ul class="side-nav">
        <li class="side-nav-item">
            <a href="{{ route('dawnstar.dashboard.index') }}" class="side-nav-link">
                <i class="uil-home-alt"></i>
                <span>@lang('Core::dashboard.title')</span>
            </a>
        </li>

        @foreach(panelMenu() as $menu)
            @if(count($menu['children']) == 0)
                <li class="side-nav-item">
                    <a href="{{ $menu['url'] }}" class="side-nav-link">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span>{{ $menu['name'] }}</span>
                    </a>
                </li>
            @else
                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#{{ $menu['url'] }}" aria-expanded="false" aria-controls="{{ $menu['url'] }}" class="side-nav-link">
                        <i class="{{ $menu['icon'] }}"></i>
                        <span>{{ $menu['name'] }}</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="{{ $menu['url'] }}">
                        <ul class="side-nav-second-level">
                            @foreach($menu['children'] as $childMenu)
                                <li>
                                    <a href="{{ $childMenu['url'] }}">
                                        {{ $childMenu['name'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
            @endif
        @endforeach

        @if($containers->isNotEmpty())
            <li class="side-nav-title side-nav-item"></li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#page" aria-expanded="false" aria-controls="page" class="side-nav-link">
                    <i class="mdi mdi-book-open-page-variant"></i>
                    <span>@lang('Core::panel_menu.page')</span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="page">
                    <ul class="side-nav-second-level">
                        @foreach($containers as $container)
                            <li>
                                <a href="{{ route('dawnstar.structures.pages.index', [$container->structure]) }}">{{ $container->translation->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </li>
        @endif
    </ul>
    <div class="clearfix"></div>
</div>
