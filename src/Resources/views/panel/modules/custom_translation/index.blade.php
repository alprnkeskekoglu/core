@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header', ['headerTitle' => __('Core::custom_translation.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-3">
                        <div class="col-lg-4 col-md-6">
                            <input type="text" class="form-control" id="search" placeholder="Search...">
                        </div>
                    </div>

                    <div class="customTranslations">
                        @include('Core::modules.custom_translation.ajax')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $('#search').on('keyup', function () {
            var search = $(this).val();
            $.ajax({
                url: '{{ route('dawnstar.custom_translations.search') }}',
                data: {search},
                method: 'GET',
                success: function (response) {
                    $('.customTranslations').html(response);
                }
            })
        });

        $('body').delegate('.deleteBtn', 'click', function (e) {
            var self = $(this);
            var key = self.attr('data-key');
            $.ajax({
                url: '{{ route('dawnstar.custom_translations.destroy') }}',
                data: {key, '_token': '{{ csrf_token() }}'},
                method: 'DELETE',
                success: function (response) {
                    self.closest('.customTranslationBox').remove();
                    showMessage('success', response.success)
                },
                error: function (response) {
                    showMessage('error', response.responseJSON.error)
                }
            })
        });

        var typingTimer;
        var doneTypingInterval = 250;
        var typedInput;

        $('body').delegate('.languageInput', 'keyup', function (e) {
            clearTimeout(typingTimer);
            typedInput = $(this);
            typingTimer = setTimeout(updateCustomTranslation, doneTypingInterval);
        });

        $('body').delegate('.languageInput', 'keydown', function () {
            clearTimeout(typingTimer);
        });

        function updateCustomTranslation() {
            var id = typedInput.attr('data-id');
            var value = typedInput.val();
            $.ajax({
                url: '{{ route('dawnstar.custom_translations.update') }}',
                data: {id, value, '_token': '{{ csrf_token() }}'},
                method: 'PUT',
                success: function (response) {
                    showMessage('success', response.success)
                },
                error: function (response) {
                    showMessage('error', response.responseJSON.error)
                }
            })
        }

    </script>
@endpush
