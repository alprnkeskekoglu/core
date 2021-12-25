<div class="card-body">
    <h4 class="header-title">@lang('Core::dashboard.page_views')</h4>

    <div class="table-responsive mt-3">
        <table class="table table-sm mb-0 font-13">
            <thead>
            <tr>
                <th>@lang('Core::dashboard.page')</th>
                <th>@lang('Core::dashboard.views')</th>
                <th>@lang('Core::dashboard.rate')</th>
            </tr>
            </thead>
            <tbody>
            @foreach($pageViews as $page)
                <tr>
                    <td>
                        <a href="{{ url($page['url']) }}" class="text-muted">{{ $page['url'] }}</a>
                    </td>
                    <td>{{ $page['count'] }}</td>
                    <td>{{ $page['rate'] }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
