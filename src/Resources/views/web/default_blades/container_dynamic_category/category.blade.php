@php
    $category = $dawnstar->relation->category;
    $pages = $category->pages;
@endphp

<div class="container">
    <h1 class="my-4">{!! $dawnstar->container->detail->name !!}</h1>

    <div class="row">
        <div class="col-md-8">
            <h3 class="my-3">{!! $category->detail->name !!}</h3>
            {!! $category->detail->detail !!}
        </div>

        <div class="col-md-4">
            @if($category->mf_)
                <img class="img-fluid" src="{!! media($category->mf_->id) !!}" alt="">
            @endif
        </div>

    </div>

    <br>

    <h1 class="my-4">Sayfalar</h1>
    <div class="row">
        @foreach($pages as $page)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="{!! $page->detail->url !!}">
                        @if($page->f_)
                            @if(is_a($page->f_, 'Illuminate\Database\Eloquent\Collection')) {
                            <img class="card-img-top" src="{!! $page->f_->first() !!}" height="200" alt="">
                            @else
                                <img class="card-img-top" src="{!! $page->f_ !!}" height="200" alt="">
                            @endif
                        @else
                            <img class="card-img-top" src="http://placehold.it/200x200" alt="">
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
