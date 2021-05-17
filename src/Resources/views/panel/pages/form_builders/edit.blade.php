@extends('DawnstarView::layouts.app')

@php
    $data = $formBuilder->data;
    $elementOrder = ['general' => 'Genel', 'languages' => 'Dile Bağlı'];
@endphp

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-8">
                    <div class="block block-rounded">
                        <div class="block-content">
                            <div class="row items-push justify-content-end text-right">
                                <div class="mr-2">
                                    <button type="button" onclick="orderSave()" class="btn btn-sm btn-primary" data-toggle="click-ripple">
                                        <i class="fa fa-fw fa-plus mr-1"></i>
                                        Sıralama Kaydet
                                    </button>
                                </div>
                            </div>
                            @foreach($elementOrder as $key => $name)
                                @continue(!isset($data[$key]))
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">{{ $name }}</h3>
                                    </div>
                                    <div class="block-content">
                                        <div class="row sortable">
                                            @foreach($data[$key] as $element)
                                                <div class="{{ $element['parent_class'] ?? 'col-md-12' }}"  id="{{ $element['name'] }}">
                                                    <div class="my-1">
                                                        <div class="btn bg-black-10 w-100">
                                                            {{ formBuilderLabel($element, session('dawnstar.language.code')). ' - ' . $element['type'] }}
                                                            <span class="float-right badge badge-danger mt-1" onclick="deleteElement('{{ $formBuilder->id }}', '{{ $key }}', '{{ $element['name'] }}')"><i class="fa fa-times"></i></span>
                                                            <span class="float-right badge badge-success mt-1 mr-1" onclick="showModal('{{ $formBuilder->id }}', '{{ $key }}', '{{ $element['name'] }}')"><i class="fa fa-edit"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="block block-rounded">
                                <div class="block-content">
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="btn bg-black-10 w-100">
                                                Meta Tags
                                                <span class="float-right badge badge-success mt-1 mr-1" onclick="showModal('{{ $formBuilder->id }}', 'metas', '')"><i class="fa fa-edit"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="block block-rounded">
                        <div class="block-content">
                            @foreach($formBuilderTypes as $formBuilderType)
                                <button class="btn bg-black-10 w-100 my-1" onclick="showNewModal('{{ $formBuilder->id }}', '{{ $formBuilderType }}')">{{ $formBuilderType }}</button>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div class="modal" id="form-builder-modal" tabindex="-1" aria-labelledby="modal-default-large" aria-hidden="true">
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(".sortable").sortable();

        function orderSave() {
            var data = {};
            var keys = {0: 'general', 1: 'languages'};
            $.each($(".sortable"), function (k,v) {
                data[keys[k]] = $(v).sortable('toArray', { attribute: 'id' })
            })

            $.ajax({
                'url': '{{ route('dawnstar.form_builders.saveOrder') }}',
                'method': 'POST',
                'data': {'id': '{{ $formBuilder->id }}', 'data': data, '_token': '{{ csrf_token() }}'},
                success: function (response) {
                }
            })
        }

        function showModal(id, key, name, isNew = false) {
            $.ajax({
                'url': '{{ route('dawnstar.form_builders.showModal') }}',
                'method': 'GET',
                'data': {id, key, name, isNew},
                success: function (response) {
                    $('#form-builder-modal').html(response);
                    $('#form-builder-modal').modal('show');
                }
            })
        }

        function showNewModal(id, inputType) {
            $.ajax({
                'url': '{{ route('dawnstar.form_builders.showNewModal') }}',
                'method': 'GET',
                'data': {id, inputType},
                success: function (response) {
                    $('#form-builder-modal').html(response);
                    $('#form-builder-modal').modal('show');
                }
            })
        }

        function deleteElement(id, key, name) {
            if(confirm('Are you sure?')) {
                $.ajax({
                    'url': '{{ route('dawnstar.form_builders.deleteElement') }}',
                    'method': 'POST',
                    'data': {id, key, name, '_token': '{{ csrf_token() }}'},
                    success: function (response) {
                       // location.reload();
                    }
                })
            }
        }
    </script>
@endpush
