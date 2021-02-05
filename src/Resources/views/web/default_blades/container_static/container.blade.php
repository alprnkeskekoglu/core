<div class="container">
    <h1 class="my-4">{!! $dawnstar->container->detail->name !!}</h1>

    <div class="row">
        <div class="col-md-8">
            <h3 class="my-3">{!! $dawnstar->container->detail->name !!}</h3>
            {!! $dawnstar->container->detail->detail !!}
            <h1>{{ custom('history.test2', 'Alperen 3TR') }}</h1>
        </div>
        <div class="col-md-4">
            @if($dawnstar->container->mf_)
                <img class="img-fluid" src="{!! media($dawnstar->container->mf_->id) !!}" alt="">
            @endif
        </div>

    </div>
</div>
