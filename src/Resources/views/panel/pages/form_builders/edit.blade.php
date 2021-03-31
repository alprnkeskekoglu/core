@extends('DawnstarView::layouts.app')

@php
    $data = $formBuilder->data;
    $elementOrder = ['general', 'languages', 'metas'];
@endphp

@section('content')
    <main id="main-container">
        <div class="content">
            <div class="row">
                <div class="col-md-8">
                    <div class="block block-rounded">
                        <div class="block-content">
                            @foreach($elementOrder as $key)
                                @continue(!isset($data[$key]) || $key == 'metas')
                                <div class="block block-rounded">
                                    <div class="block-header block-header-default">
                                        <h3 class="block-title">{{ $key }}</h3>
                                    </div>
                                    <div class="block-content">
                                        <div class="row">
                                            @foreach($data[$key] as $element)
                                                <div class="{{ $element['parent_class'] ?? 'col-md-12' }}">
                                                    <button class="btn bg-black-10 w-100 my-1"
                                                            onclick="showModal('{{ $formBuilder->id }}', '{{ $key }}', '{{ $element['name'] }}')">{{ formBuilderLabel($element, session('dawnstar.language.code')). ' - ' . $element['type'] }}</button>
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
                                            <button class="btn bg-black-10 w-100 my-1" onclick="showModal('{{ $formBuilder->id }}', 'metas', '')">Meta Tags</button>
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
                                <button class="btn bg-black-10 w-100 my-1">{{ $formBuilderType }}</button>
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
    <script>
        function showModal(id, key, name) {
            $.ajax({
                'url': '{{ route('dawnstar.form_builders.showModal') }}',
                'method': 'GET',
                'data': {id, key, name},
                success: function (response) {
                    $('#form-builder-modal').html(response);
                    $('#form-builder-modal').modal('show');
                }
            })
        }
    </script>
@endpush
