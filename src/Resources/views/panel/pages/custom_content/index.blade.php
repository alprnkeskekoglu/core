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

@push('scripts')
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
    </script>

    <script>
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
    </script>
@endpush
