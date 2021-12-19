<div class="card-body">
    <h4 class="header-title mb-3">@lang('Dawnstar::dashboard.sessions_overview')</h4>
    <div dir="ltr">
        <div id="sessions-overview" class="apex-charts mt-3"></div>
    </div>
</div>

<script>
    var options = {
        series: [{
            name: "Sessions",
            data: [{{ implode(', ', $sessions) }}]
        }],
        chart: {
            type: 'area',
            height: 309,
            zoom: {
                enabled: false
            },
            toolbar: {
                tools: {
                    download: false
                }
            },
        },
        zoom: {enabled: false},
        legend: {show: false},
        dataLabels: {enabled: false},
        colors: ["#727cf5", "#0acf97", "#fa5c7c", "#ffbc00"],
        stroke: {
            curve: "smooth",
            width: 4
        },
        xaxis: {
            type: 'string',
            categories: ["{!! implode('", "', array_keys($sessions)) !!}"],
            tooltip: {enabled: false},
            axisBorder: {show: false}
        },
        yaxis: {
            labels: {
                formatter: function (e) {
                    return e
                }, offsetX: -15
            }
        },
        fill: {
            type: "gradient",
            gradient: {
                type: "vertical",
                shadeIntensity: 1,
                inverseColors: !1,
                opacityFrom: .45,
                opacityTo: .05,
                stops: [45, 100]
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#sessions-overview"), options);
    chart.render();
</script>