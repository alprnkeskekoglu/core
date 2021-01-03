<div class="container">
    <h1 class="my-4">{!! $container->detail->name !!}</h1>

    <div class="row">
        @foreach($pages as $page)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="{!! $page->detail->url !!}">
                        @if($page->f_)
                            @if(is_a($page->f_, 'Illuminate\Database\Eloquent\Collection'))
                                <img class="img-fluid" src="{!! image($page->f_->first()->id)->resize(['w' => 1050, 'h' => 300]) !!}" width="1050" height="300" alt="">
                            @else
                                <img class="card-img-top img-fluid" src="{!! image($page->f_->id)->resize(['w' => 1050, 'h' => 300]) !!}" width="1050" height="300" alt="">
                            @endif
                        @else
                            <img class="card-img-top img-fluid" src="http://placehold.it/1050x300" width="1050" height="300" alt="">
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
    @if($pages instanceof \Illuminate\Pagination\LengthAwarePaginator )
        {!! $pages->links() !!}
    @endif
</div>
