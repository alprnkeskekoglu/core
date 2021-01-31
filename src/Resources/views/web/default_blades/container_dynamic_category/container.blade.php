@php
    $categories = $dawnstar->container->categories;
@endphp
<div class="container">
    <h1 class="my-4">{!! $dawnstar->container->detail->name !!}</h1>

    <div class="row">
        @foreach($categories as $category)
            <div class="col-lg-4 col-sm-6 mb-4">
                <div class="card h-100">
                    <a href="{!! $category->detail->url !!}">
                        @if($category->mf_)
                            <img class="img-fluid" src="{!! media($category->mf_->id) !!}" alt="">
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
