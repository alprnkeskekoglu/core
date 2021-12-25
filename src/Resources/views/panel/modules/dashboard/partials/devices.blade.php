<div class="card-body">
    <h4 class="header-title">@lang('Core::dashboard.devices')</h4>
    <div id="sessions-device" class="apex-charts mt-3"></div>
</div>

<script>
    var options = {
        chart: {
            width: 343,
            type: 'donut',
        },
        series: [{{ implode(', ', $devices) }}],
        labels: ['{!! implode("', '", array_keys($devices)) !!}'],
        dataLabels: {enabled: true},
        plotOptions: {
            radar: {
                size: 130,
                polygons: {
                    strokeColor: "#e9e9e9",
                    fill: {
                        colors: ["#f8f8f8", "#fff"]
                    }
                }
            }
        },
    };

    var chart = new ApexCharts(document.querySelector("#sessions-device"), options);
    chart.render();
</script>
