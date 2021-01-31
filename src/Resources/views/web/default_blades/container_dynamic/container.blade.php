<div class="container">
    <h1 class="my-4">{!! $dawnstar->container->detail->name !!}</h1>

    <div class="row">
        @foreach($dawnstar->container->pages as $page)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="{!! $page->detail->url !!}">
                        @if($page->mf_)
                            <img class="img-fluid" src="{!! media($page->mf_->id) !!}" alt="">
                        @endif
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{!! $page->detail->url !!}">{!! $page->detail->name !!}</a>
                        </h4>
                        <p class="card-text small">
                            {!! $page->detail->detail ? \Str::limit(strip_tags($page->detail->detail), 80) : "" !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
