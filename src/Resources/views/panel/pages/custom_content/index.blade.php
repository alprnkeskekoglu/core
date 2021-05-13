@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::custom_content.index_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <div class="block-content">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <input type="text"
                                       class="form-control"
                                       placeholder="{{ __('DawnstarLang::custom_content.search') }}"
                                       name="search">
                            </div>
                        </div>
                    </div>

                    <div class="accordionDiv">
                        @include('DawnstarView::pages.custom_content.ajax')
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        var typingTimer;
        var doneTypingInterval = 350;
        var typedInput;

        $('body').delegate('.languageInput', 'keyup', function () {
            clearTimeout(typingTimer);
            typedInput = $(this);
            typingTimer = setTimeout(doneTyping, doneTypingInterval);
        });

        $('body').delegate('.languageInput', 'keydown', function () {
            clearTimeout(typingTimer);
        });

        function doneTyping() {
            var key = typedInput.attr('data-key');
            var languageId = typedInput.attr('data-language');
            var value = typedInput.val();

            $.ajax({
                'url': '{{ route('dawnstar.custom_contents.update') }}',
                'data': {'key': key, 'language_id': languageId, 'value': value},
                'method': 'GET',
                success: function (response) {
                    typedInput.addClass('border-success');
                    setTimeout(function () {
                        typedInput.removeClass('border-success');
                    }, 750);
                },
                error: function (response) {
                    typedInput.addClass('border-danger');
                    setTimeout(function () {
                        typedInput.removeClass('border-danger');
                    }, 750);
                }
            })
        }

        $('input[name="search"]').on('keyup', function () {

            var value = $(this).val();

            $.ajax({
                'url': '{{ route('dawnstar.custom_contents.search') }}',
                'data': {'search': value},
                'method': 'GET',
                success: function (response) {
                    $('.accordionDiv').html(response);
                }
            })
        });

        $('button.deleteBtn').on('click', function () {
            var key = $(this).attr('data-key');
            var self = $(this);

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
                preConfirm: e => {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            resolve();
                        }, 50);
                    });
                }
            }).then(result => {
                if (result.value) {
                    $.ajax({
                        'url': '{{ route('dawnstar.custom_contents.delete') }}',
                        'data': {key, '_token':'{{ csrf_token() }}'},
                        'method': 'POST',
                        success: function (response) {
                            swal.fire('{{ __('DawnstarLang::general.swal.success.title') }}', '{{ __('DawnstarLang::general.swal.success.subtitle') }}', 'success');
                            self.closest('.block').remove();
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
