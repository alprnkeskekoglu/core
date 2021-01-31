@php
    $page = $dawnstar->relation->page;
@endphp
<div class="container">
    <h1 class="my-4">{!! $dawnstar->container->detail->name !!}</h1>

    <div class="row">
        <div class="col-md-8">
            <h3 class="my-3">{!! $page->detail->name !!}</h3>
            {!! $page->detail->detail !!}

        </div>

        <div class="col-md-4">
            @if($page->mf_)
                <img class="img-fluid" src="{!! media($page->mf_->id) !!}" alt="">
            @endif
        </div>
    </div>
</div>
