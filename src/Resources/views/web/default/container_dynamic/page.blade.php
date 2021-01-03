@php

    $subPages = isset($subPages) ? $subPages : collect();
@endphp
<div class="container">
    <h1 class="my-4">{!! $container->detail->name !!}</h1>

    <div class="row">
        <div class="col-md-8">
            <h3 class="my-3">{!! $page->detail->name !!}</h3>
            {!! $page->detail->detail !!}

        </div>

        <div class="col-md-4">
            @if($page->f_)
                @if(is_a($page->f_, 'Illuminate\Database\Eloquent\Collection'))
                    <img class="img-fluid" src="{!! $page->f_->first() !!}" alt="">
                @else
                    <img class="card-img-top img-fluid" src="{!! $page->f_ !!}" alt="">
                @endif
            @else
                <img class="card-img-top img-fluid" src="http://placehold.it/380x230" alt="">
            @endif
        </div>
    </div>

    @if($subPages->isNotEmpty())
        <div class="h3 mt-5">
            Alt Sayfalar
        </div>

        <div class="row">
            @foreach($subPages as $subPage)
                <div class="col-lg-3 col-sm-4 mb-4">
                    <div class="card h-100">
                        <a href="{!! $subPage->detail->url !!}">
                            @if($subPage->f_)
                                @if(is_a($subPage->f_, 'Illuminate\Database\Eloquent\Collection'))
                                    <img class="img-fluid"
                                         src="{!! image($subPage->f_->first()->id)->resize(['w' => 1050, 'h' => 300]) !!}"
                                         width="1050" height="300" alt="">
                                @else
                                    <img class="card-img-top img-fluid"
                                         src="{!! image($subPage->f_->id)->resize(['w' => 1050, 'h' => 300]) !!}"
                                         width="1050" height="300" alt="">
                                @endif
                            @else
                                <img class="card-img-top img-fluid" src="http://placehold.it/1050x300" width="1050"
                                     height="300" alt="">
                            @endif
                        </a>
                        <div class="card-body">
                            <h4 class="card-title">
                                <a href="{!! $subPage->detail->url !!}">{!! $subPage->detail->name !!}</a>
                            </h4>
                            <p class="card-text small">
                                {!! $subPage->detail->detail ? \Str::limit(strip_tags($subPage->detail->detail), 80) : "" !!}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
