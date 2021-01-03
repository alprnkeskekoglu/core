<div class="container">
    <h1 class="my-4">{!! $container->detail->name !!}</h1>

    <div class="row">
        <div class="col-md-8">
            <h3 class="my-3">{!! $container->detail->name !!}</h3>
            {!! $container->detail->detail !!}
        </div>

        <div class="col-md-4">
            @if($container->f_)
                @if(is_a($container->f_, 'Illuminate\Database\Eloquent\Collection'))
                    <img class="img-fluid" src="{!! $container->f_->first() !!}" alt="">
                @else
                    <img class="card-img-top img-fluid" src="{!! $container->f_ !!}" alt="">
                @endif
            @else
                <img class="card-img-top img-fluid" src="http://placehold.it/380x230" alt="">
            @endif
        </div>

    </div>
</div>
