@extends('Core::layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <form class="d-flex">
                        <div class="input-group me-2">
                            <input type="date" name="start_date" value="{{ request('start_date', \Carbon\Carbon::now()->subWeek()->format('Y-m-d')) }}" max="{{ date('Y-m-d') }}" class="form-control form-control-light">
                        </div>
                        <div class="input-group">
                            <input type="date" name="end_date" value="{{ request('end_date', date('Y-m-d')) }}" min="{{ \Carbon\Carbon::now()->subWeek()->format('Y-m-d') }}" max="{{ date('Y-m-d') }}" class="form-control form-control-light">
                        </div>
                        <button type="button" id="refreshBtn" class="btn btn-primary ms-2">
                            <i class="mdi mdi-autorenew"></i>
                        </button>
                    </form>
                </div>
                <h4 class="page-title">@lang('Core::dashboard.title')</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-3 col-lg-4">
            <div class="card tilebox-one" id="activeUsers">
            </div>

            <div class="card tilebox-one" id="userCount">
            </div>

            <div class="card tilebox-one" id="viewsPerMinute">
            </div>
        </div>
        <div class="col-xl-9 col-lg-8">
            <div class="card card-h-100" id="sessions">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-4 col-lg-6">
            <div class="card" id="devices">
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card" id="operatingSystems">
            </div>
        </div>
        <div class="col-xl-4 col-lg-6">
            <div class="card" id="browsers">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 col-md-12">
            <div class="card" id="pageViews">
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card" id="weeklyViews">
            </div>
        </div>
        <div class="col-lg-4 col-md-12">
            <div class="card" id="referers">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('vendor/dawnstar/core/js/apexcharts.min.js') }}"></script>
    <script>

        var types = [
            'userCount',
            'viewsPerMinute',
            'sessions',
            'devices',
            'operatingSystems',
            'browsers',
            'pageViews',
            'weeklyViews',
            'referers',
        ];

        $(document).ready(function () {
            setTimeout(function () {
                getActiveUsers()
                $.each(types, function (k, type) {
                    getReport(type);
                });
            }, 500)
        });


        $('#start_date').on('change', function () {
            $('#finish_date').attr('min', $(this).val());
        });

        $('#finish_date').on('change', function () {
            $('#start_date').attr('max', $(this).val());
        });

        $('#refreshBtn').on('click', function () {
            $.each(types, function (k, type) {
                getReport(type);
            });
        })

        function getActiveUsers() {
            getReport('activeUsers');

            setTimeout(function () {
                getActiveUsers('activeUsers')
            }, 10000)
        }

        function getReport(report) {
            var start_date = $('#start_date').val();
            var end_date = $('#end_date').val();
            $.ajax({
                url: '{{ route('dawnstar.dashboard.getReport') }}',
                data: {report, start_date, end_date},
                success: function (response) {
                    $('#' + report).html(response);
                }
            })
        }
    </script>
@endpush
