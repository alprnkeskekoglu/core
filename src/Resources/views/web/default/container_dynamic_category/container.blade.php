<div class="container">
    <h1 class="my-4">{!! $container->detail->name !!}</h1>
    @include("ContentWeb::default.layouts.breadcrumb")

    <div class="row">
        @foreach($categories as $category)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="{!! $category->detail->url !!}">
                        @if($category->f_)
                            @if(is_a($category->f_, 'Illuminate\Database\Eloquent\Collection'))
                            <img class="card-img-top" src="{!! $category->f_->first() !!}" height="200" alt="">
                            @else
                                <img class="card-img-top" src="{!! $category->f_ !!}" height="200" alt="">
                            @endif
                        @else
                            <img class="card-img-top" src="http://placehold.it/200x200" alt="">
                        @endif
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{!! $category->detail->url !!}">{!! $category->detail->name !!}</a>
                        </h4>
                        <p class="card-text">
                            {!! $category->detail->detail ? \Str::limit(strip_tags($category->detail->detail), 80) : "" !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
