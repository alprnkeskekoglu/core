<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="{!! url($mediapress->homePageUrl->url) !!}">
                <img src="{!! settingSun('logo.desktop_logo') ?
                                image(settingSun('logo.desktop_logo')) :
                                asset('vendor/mediapress/images/logo-m.jpg') !!}"
                     width="30" height="30"
                     class="d-inline-block align-top" alt="">
                {!! settingSun('logo.desktop_logo') == null ? 'Mediapress' : '' !!}
            </a>
        </nav>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                @foreach($mediapress->menu('header-menu') as $menu)
                    <li class="nav-item {{$menu->children->isNotEmpty() ? 'dropdown' : ''}}">
                        @if($menu->children->isNotEmpty())
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{$menu->id}}" role="button"
                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {!! $menu->name !!}
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{$menu->id}}">
                                @foreach($menu->children as $child)
                                <a class="dropdown-item" href="{!! $child->url !!}">{!! $child->name !!}</a>
                                @endforeach
                            </div>
                        @else
                            <a class="nav-link" href="{!! $menu->url !!}">{!! $menu->name !!} </a>
                        @endif
                    </li>
                @endforeach
            </ul>
            @php
                $search = \Mediapress\Modules\Content\Models\Sitemap::where('feature_tag', 'search')
                    ->whereHas('detail')
                    ->first();
            @endphp
            @if($search)
                <form action="{!! searchUrl() !!}">
                    <div class="input-group">
                        <input class="form-control mr-sm-2" type="search" name="q" placeholder="{!! strip_tags(langPart('header.search_input', "Ara...")) !!}" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">{!! langPart('header.search_btn', "Ara") !!}</button>
                        </div>
                    </div>
                </form>
            @endif

            @if(count($mediapress->otherCountryGroups(1)) > 0)
                <div class="lang dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languages" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! strtoupper($mediapress->activeCountryGroup->code . "_" . $mediapress->activeLanguage->code) !!}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="languages">
                        @foreach($mediapress->otherCountryGroups(1) as $otherGroup)
                            <a class="dropdown-item" href="{!! url($otherGroup['url']->url) !!}">{!! strtoupper($otherGroup['country_group_code'] . "_" . $otherGroup['language_code']) !!}</a>
                        @endforeach
                    </div>

                </div>
            @endif
            @if(count($mediapress->otherLanguages(1)) > 0)
                <div class="lang dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="languages" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {!! strtoupper($mediapress->activeLanguage->code) !!}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="languages">
                        @foreach($mediapress->otherLanguages(1) as $otherLang)
                            <a class="dropdown-item" href="{!! url($otherLang['url']->url) !!}">{!! strtoupper($otherLang['language_code']) !!}</a>
                        @endforeach
                    </div>

                </div>
            @endif
        </div>
    </div>
</nav>

