<div class="container">
    <div class="row">
        <div class="search-pages">
            @foreach($results as $result)
                <div class="item">
                    <h6>{!! $result->detail_name !!}</h6>
                    <p>{!! \Str::limit(strip_tags($result->detail_detail, 120)) !!}</p>

                    <div class="more">
                        <a href="{!! $result->url !!}">{!! custom('search.btn', "Devamı") !!}</a>
                    </div>
                </div>
            @endforeach
            <div class="pag">
                {!! $results->links() !!}
            </div>
        </div>
    </div>
</div>

