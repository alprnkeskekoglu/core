@extends('DawnstarView::layouts.app')


@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::page.index_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <div class="block-content">
                    @include('DawnstarView::layouts.alerts')

                    <div class="row items-push justify-content-end text-right">
                        @if($container->has_detail == 1)
                            <div class="mr-2">
                                <a href="{{ route('dawnstar.containers.edit', $container) }}" class="btn btn-sm btn-primary" data-toggle="click-ripple">
                                    <i class="fa fa-fw fa-fingerprint mr-1"></i>
                                    {{ __('DawnstarLang::page.container') }}
                                </a>
                            </div>
                        @endif
                        @if($container->has_category == 1)
                            <div class="mr-2">
                                <a href="{{ route('dawnstar.containers.categories.index', $container) }}" class="btn btn-sm btn-primary" data-toggle="click-ripple">
                                    <i class="fa fa-fw fa-grip-horizontal mr-1"></i>
                                    {{ __('DawnstarLang::page.category') }}
                                </a>
                            </div>
                        @endif
                        <div class="mr-2">
                            <a href="{{ route('dawnstar.containers.pages.create', $container) }}" class="btn btn-sm btn-primary" data-toggle="click-ripple">
                                <i class="fa fa-fw fa-plus mr-1"></i>
                                {{ __('DawnstarLang::general.add_new') }}
                            </a>
                        </div>
                    </div>

                    <table class="table table-striped table-vcenter dataTable">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th class="text-center">{{ __('DawnstarLang::page.labels.status') }}</th>
                            <th>{{ __('DawnstarLang::page.labels.name') }}</th>
                            <th>{{ __('DawnstarLang::page.labels.slug') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('DawnstarLang::general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        var table = $('.dataTable').DataTable({
            "iDisplayLength": 10,
            "bProcessing": true,
            "bServerSide": true,
            "info": false,
            "ordering": false,
            "language": {
                "lengthMenu": '{{ __("DawnstarLang::general.datatable.lengthMenu") }}',
                "search": '{{ __("DawnstarLang::general.datatable.search") }}'
            },
            columns: [
                {data: "order"},
                {data: "status"},
                {data: "name"},
                {data: "slug"},
                {
                    defaultContent: '' +
                        '<div class="dropdown">\n' +
                        '<div class="btn-group">' +
                            '<a href="" class="btn btn-sm btn-primary edit" data-toggle="tooltip" data-placement="bottom" title="{{ __('DawnstarLang::general.edit') }}">'+
                                '<i class="fa fa-pencil-alt"></i>' +
                            '</a>' +

                            '<button type="button" class="deleteBtn btn btn-sm btn-danger delete" data-toggle="tooltip" data-placement="bottom" data-url="" title="{{ __('DawnstarLang::general.delete') }}">' +
                                '<i class="fa fa-times"></i>' +
                            '</button>' +
                        '</div>' +
                        '</div>'
                },
            ],
            columnDefs: [//Update Columns
                {
                    targets: 1,
                    'createdCell':  function (td, cellData, rowData, row, col) {
                        if(rowData.status == 1) {
                            var badge = 'success';
                            var text = '{{ __('DawnstarLang::general.status_title.active') }}'
                        } else if(rowData.status == 3) {
                            var badge = 'danger';
                            var text = '{{ __('DawnstarLang::general.status_title.passive') }}'
                        } else {
                            var badge = 'secondary';
                            var text = '{{ __('DawnstarLang::general.status_title.draft') }}'
                        }

                        $(td).addClass('text-center');
                        $(td).html('<span class="badge badge-'+badge+' fa-1x p-2">'+ text + '</span>');
                    }
                },
                {
                    targets: 4,
                    'createdCell':  function (td, cellData, rowData, row, col) {
                        $(td).find('.edit').first().attr('href', "/dawnstar/containers/" + rowData.container_id + "/pages/" + rowData.id + "/edit");
                        $(td).find('.delete').first().attr('data-url', "/dawnstar/containers/" + rowData.container_id + "/pages/" + rowData.id);
                    }
                },
            ],
            ajax: {
                url: "{!! route("dawnstar.containers.pages.getPageList", $container) !!}",
                method: "GET",
                "dataSrc": function (response) { //ajax success
                    $('#dataTable-count').html(response.recordsTotal);
                    return response.data;
                }
            },
        }).on('preDraw', function () {
            if ($('.dataTables_paginate > span > a.paginate_button').length > 1) {
                $('.dataTables_paginate').css('display', 'block');
            } else {
                $('.dataTables_paginate').css('display', 'none');
            }
            $('.dataTables_filter input').addClass('form-control');
            $('.dataTables_length select').addClass('form-control-plaintext');
        })


        $('body').delegate('.deleteBtn', 'click', function () {
            var url = $(this).attr('data-url');
            swal.fire({
                title: '{{ __('DawnstarLang::general.swal.title') }}',
                text: '{{ __('DawnstarLang::general.swal.subtitle') }}',
                icon: 'warning',
                showCancelButton: true,
                customClass: {
                    confirmButton: 'btn btn-danger m-1',
                    cancelButton: 'btn btn-secondary m-1'
                },
                confirmButtonText: '{{ __('DawnstarLang::general.swal.confirm_btn') }}',
                cancelButtonText: '{{ __('DawnstarLang::general.swal.cancel_btn') }}',
                html: false,
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        'url': url,
                        'method': 'DELETE',
                        'data': {'_token': '{{ csrf_token() }}'},
                        success: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.success.title') }}', '{{ __('DawnstarLang::general.swal.success.subtitle') }}', 'success');
                            setTimeout(function () {
                                location.reload();
                            }, 1000);
                        },
                        error: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.error.title') }}', '{{ __('DawnstarLang::general.swal.error.subtitle') }}', 'error');
                        }
                    })
                }
            });
        })
    </script>
@endpush
