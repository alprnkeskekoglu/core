<div class="col-md-4">
    <div id="devices" class="w-100"></div>
</div>

@push('after_scripts')
    <script>
        Highcharts.chart('devices', {
            chart: {type: 'pie'},
            title: {text: 'Cihazlar'},
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
                    @foreach($devices as $device)
                    {
                        name: '{{ $device['name'] }}',
                        y: parseFloat('{{ $device['rate'] }}'),
                        sliced: '{{ $loop->first ? 'true' : 'false' }}' == 'true',
                    },
                    @endforeach
                ]
            }]
        });
    </script>
@endpush
