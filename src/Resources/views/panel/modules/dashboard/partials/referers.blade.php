<div class="card-body">
    <h4 class="header-title">@lang('Core::dashboard.channels')</h4>

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
            @foreach($referers as $referer)
                <tr>
                    <td class="text-muted">
                        {{ $referer['name'] }}
                    </td>
                    <td>{{ $referer['count'] }}</td>
                    <td>{{ $referer['rate'] }}%</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>