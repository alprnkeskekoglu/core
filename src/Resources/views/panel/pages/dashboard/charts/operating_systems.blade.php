<div class="col-md-4">
    <div id="operating_systems" class="w-100"></div>
</div>

@push('after_scripts')
    <script>
        Highcharts.chart('operating_systems', {
            chart: {type: 'pie'},
            title: {text: 'İşletim Sistemleri'},
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
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            }, series: [{
                name: 'Oran',
                colorByPoint: true,
                data: [
                    @foreach($operatingSystems as $operatingSystem)
                    {
                        name: '{{ $operatingSystem['name'] }}',
                        y: parseFloat('{{ $operatingSystem['rate'] }}'),
                        sliced: '{{ $loop->first ? 'true' : 'false' }}' == 'true',
                    },
                    @endforeach
                ]
            }]
        });
    </script>
@endpush
