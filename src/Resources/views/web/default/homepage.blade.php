@php
    $sitemap = $mediapress->data['sitemap'];
    $scenes = $mediapress->data['scenes'];
@endphp

<div class="container">
    <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            @foreach($scenes as $scene)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    <img class="d-block w-100" src="{{ $scene['image'] }}" alt="First slide">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>{!! $scene['texts'][0] ?? "" !!}</h5>

                        {!! $scene['buttons'][0] ?? "" !!}
                    </div>
                </div>
            @endforeach
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    <section>
        <div class="row">
            <div class="col-md-12">
                <h3 class="my-3">{!! $sitemap->detail->name !!}</h3>
                {!! $sitemap->detail->detail !!}
            </div>
        </div>
    </section>
</div>
