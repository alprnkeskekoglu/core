<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="{!! $dawnstar->homePageUrl() !!}">
                <img src="{{ defaultImage() }}"
                     width="30" height="30"
                     class="d-inline-block align-top" alt="">
                {!! $dawnstar->website->name !!}
            </a>
        </nav>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @foreach(menu('header-menu') as $menu)
                    <li class="nav-item {{ count($menu['children']) > 0 ? 'dropdown' : '' }}">
                        @if(count($menu['children']) > 0)
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $menu['id'] }}" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {!! $menu['name'] !!}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $menu['id'] }}">
                                @foreach($menu['children'] as $child)
                                    <a class="dropdown-item" href="{!! $child['url'] !!}">{!! $child['name'] !!}</a>
                                @endforeach
                            </div>
                        @else
                            <a class="nav-link" href="{!! $menu['url'] !!}">{!! $menu['name'] !!} </a>
                        @endif
                    </li>
                @endforeach
            </ul>
            @php
                $search = \Dawnstar\Models\Container::where('key', 'search')
                    ->where('website_id', dawnstar()->website->id)
                    ->first();
            @endphp
            @if($search)
                <form action="{{ searchUrl() }}">
                    <div class="input-group">
                        <input class="form-control mr-sm-2" type="search" name="q" placeholder="{!! custom('header.search_input', "Ara...") !!}" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{!! custom('header.search_btn', "Ara") !!}</button>
                        </div>
                    </div>
                </form>
            @endif

            @if(count($dawnstar->otherLanguages(1)) > 0)
                <div class="lang dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languages" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! strtoupper($dawnstar->language->code) !!}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="languages">
                        @foreach($dawnstar->otherLanguages(1) as $otherLang)
                            <a class="dropdown-item" href="{!! $otherLang['url'] !!}">{!! strtoupper($otherLang['language_code']) !!}</a>
                        @endforeach
                    </div>

                </div>
            @endif
        </div>
    </div>
</nav>

