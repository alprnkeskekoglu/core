<div class="col-md-12">
    <div id="views" class="w-100"></div>
</div>

@push('after_scripts')
    <script>
        Highcharts.chart('views', {
            chart: {type: 'area'},
            title: {text: 'Sayfa Görüntülenme'},
            xAxis: {
                allowDecimals: false,
            },
            plotOptions: {
                area: {
                    pointStart: 0,
                    marker: {
                        enabled: false,
                        symbol: 'circle',
                        radius: 2,
                        states: {
                            hover: {
                                enabled: true
                            }
                        }
                    }
                }
            },
            series: [{
                name: 'Görüntülenme Sayısı',
                data: [{{ implode(', ', $views['views']) }}]
            }, {
                name: 'Kullanıcı Sayısı',
                data: [{{ implode(', ', $views['uniqueUsers']) }}]
            }]
        });
    </script>
@endpush
