@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::page.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.structures.pages.create', $structure) }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <table class="table table-centered mb-0" id="pageTable">
                        <thead>
                        <tr>
                            @foreach($columns as $column)
                                <th>{{ $column['label'] }}</th>
                            @endforeach
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/assets/plugins/datatable/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/assets/plugins/datatable/css/responsive.bootstrap5.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/dawnstar/assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/assets/plugins/datatable/js/responsive.bootstrap5.min.js') }}"></script>

    <script>
        $('#pageTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('dawnstar.structures.pages.datatable', $structure) }}',
            columns: @json($columns),
            language: {
                paginate: {
                    previous: "<i class='mdi mdi-chevron-left'>",
                    next: "<i class='mdi mdi-chevron-right'>"
                },
                lengthMenu: "@lang('Dawnstar::datatable.lengthMenu')",
                search: "@lang('Dawnstar::datatable.search')",
                info: "@lang('Dawnstar::datatable.info')",
            },
            drawCallback: function () {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded")
            }
        });
        $(".dataTables_length select").addClass("form-select form-select-sm");
        $(".dataTables_length label").addClass("form-label");
    </script>

    @if(session('success'))
        <script>
            showMessage('success', '', '{{ session('success') }}')
        </script>
    @endif
@endpush
