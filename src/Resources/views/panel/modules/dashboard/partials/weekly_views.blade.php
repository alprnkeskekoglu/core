<div class="card-body">
    <h4 class="header-title">@lang('Dawnstar::dashboard.weekly_views')</h4>
    <div id="views" class="apex-charts"></div>
</div>

<script>
    var options = {
        chart: {
            height: 345,
            type: 'heatmap',
            zoom: {
                enabled: false
            },
            toolbar: {
                tools: {
                    download: false
                }
            },
        },
        series: [
                @foreach($weeklyViews as $hour => $view)
            {
                name: '{{ $hour }}',
                data: [
                        @foreach($view as $week => $total)
                    {
                        x: '{{ $week }}',
                        y: '{{ $total }}'
                    },
                    @endforeach
                ]
            },
            @endforeach
        ],
        dataLabels: {
            enabled: false
        },
        colors: ["#008FFB"],
    };

    var chart = new ApexCharts(document.querySelector("#views"), options);
    chart.render();
</script>
