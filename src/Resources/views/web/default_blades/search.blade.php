<div class="container">
    <div class="row">
        <div class="search-pages">
            @foreach($results as $result)
                <div class="item">
                    <h6>{!! $result->detail_name !!}</h6>
                    <p>{!! searchHighlight(request()->get('q'), $result->detail_detail) !!}</p>

                    <div class="more">
                        <a href="{!! $result->url !!}">{!! langPart('search.btn', "Devamı") !!}</a>
                    </div>
                </div>
            @endforeach
            <div class="pag">
                {!! $results->links() !!}
            </div>
        </div>
    </div>
</div>

