<div class="col-md-4">
    <div id="browsers" class="w-100"></div>
</div>

@push('after_scripts')
    <script>
        Highcharts.chart('browsers', {
            chart: {type: 'pie'},
            title: {text: 'Tarayıcı'},
            accessibility: {
                point: {
                    valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: "<b>{point.name}</b>: {point.percentage:.1f} %"
                    }
                }
            }, series: [{
                name: 'Oran',
                colorByPoint: true,
                data: [
                    @foreach($browsers as $browser)
                    {
                        name: '{{ $browser['name'] }}',
                        y: parseFloat('{{ $browser['rate'] }}'),
                        sliced: '{{ $loop->first ? 'true' : 'false' }}' == 'true',
                    },
                    @endforeach
                ]
            }]
        });
    </script>
@endpush
