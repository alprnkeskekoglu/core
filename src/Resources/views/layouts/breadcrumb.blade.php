<nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
    <ol class="breadcrumb breadcrumb-alt">
        <li class="breadcrumb-item">
            <a href="{!! route('dashboard') !!}">Dashboard</a>
        </li>
        @isset($breadcrumb)
            @foreach($breadcrumb as $crumb)
                @if($loop->last())
                    <li class="breadcrumb-item active" aria-current="page">{!! $crumb['name'] !!}</li>
                @else
                    <li class="breadcrumb-item">
                        <a href="{!! $crumb['url'] !!}">{!! $crumb['name'] !!}</a>
                    </li>
                @endif
            @endforeach
        @endisset
    </ol>
</nav>
