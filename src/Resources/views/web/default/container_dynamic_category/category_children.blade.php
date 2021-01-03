<div class="container">
    <h1 class="my-4">{!! $container->detail->name !!}</h1>

    @include("ContentWeb::default.layouts.breadcrumb")

    <div class="row">
        <div class="col-md-8">
            <h3 class="my-3">{!! $category->detail->name !!}</h3>
            {!! $category->detail->detail !!}
        </div>

        <div class="col-md-4">
            @if($category->f_)
                @if(is_a($category->f_, 'Illuminate\Database\Eloquent\Collection'))
                    <img class="img-fluid" src="{!! image($category->f_->first()->id)->resize(['w' => 1050, 'h' => 300]) !!}" width="1050" height="300" alt="">
                @else
                    <img class="card-img-top img-fluid" src="{!! image($category->f_->id)->resize(['w' => 1050, 'h' => 300]) !!}" width="1050" height="300" alt="">
                @endif
            @else
                <img class="card-img-top img-fluid" src="http://placehold.it/380x230" alt="">
            @endif
        </div>

    </div>

    <br>

    <h1 class="my-4">Alt Kategoriler</h1>
    <div class="row">
        @foreach($children as $child)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="{!! $child->detail->url !!}">
                        @if($child->f_)
                            @if(is_a($child->f_, 'Illuminate\Database\Eloquent\Collection')) {
                                <img class="card-img-top" src="{!! $child->f_->first() !!}" height="200" alt="">
                            @else
                                <img class="card-img-top" src="{!! $child->f_ !!}" height="200" alt="">
                            @endif
                        @else
                            <img class="card-img-top" src="http://placehold.it/200x200" alt="">
                        @endif
                    </a>
                    <div class="card-body">
                        <h4 class="card-title">
                            <a href="{!! $child->detail->url !!}">{!! $child->detail->name !!}</a>
                        </h4>
                        <p class="card-text small">
                            {!! $child->detail->detail ? \Str::limit(strip_tags($child->detail->detail), 80) : "" !!}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
