@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::page.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        @if(auth('admin')->user()->hasRole('Super Admin'))
                        <a href="{{ route('dawnstar.module_builders.edit', $structure->moduleBuilder('page')) }}" class="btn btn-secondary">
                            @lang('ModuleBuilder::general.title.index')
                        </a>
                        @endif
                    </div>
                    <div class="float-end">
                        @if($structure->has_detail == 1)
                            <a href="{{ route('dawnstar.structures.containers.edit', [$structure, $structure->container]) }}" class="btn btn-secondary">
                                @lang('Core::general.list_page')
                            </a>
                        @endif
                        @if($structure->has_category == 1)
                            <a href="{{ route('dawnstar.structures.categories.index', [$structure]) }}" class="btn btn-secondary">
                                @lang('Core::general.category')
                            </a>
                        @endif
                        @if($structure->has_property == 1)
                            <a href="{{ route('dawnstar.structures.properties.index', [$structure]) }}" class="btn btn-secondary">
                                @lang('Core::general.property')
                            </a>
                        @endif
                        @include('Core::includes.buttons.add_new', ['route' => route('dawnstar.structures.pages.create', $structure)])
                    </div>
                </div>
                <div class="card-body">
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
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/core/plugins/datatable/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/dawnstar/core/plugins/datatable/css/responsive.bootstrap5.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('vendor/dawnstar/core/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/core/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/core/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('vendor/dawnstar/core/plugins/datatable/js/responsive.bootstrap5.min.js') }}"></script>

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
                lengthMenu: "@lang('Core::datatable.lengthMenu')",
                search: "@lang('Core::datatable.search')",
                info: "@lang('Core::datatable.info')",
                emptyTable: "@lang('Core::datatable.emptyTable')",
                processing: "@lang('Core::datatable.processing')",
                zeroRecords: "@lang('Core::datatable.zeroRecords')",
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
