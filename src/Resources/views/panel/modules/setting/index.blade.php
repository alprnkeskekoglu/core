@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::setting.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 text-center">
                            <button type="button" class="btn btn-lg btn-outline-primary" onclick="showModal('recaptcha')">
                                Recaptcha
                            </button>
                            <button type="button" class="btn btn-lg btn-outline-primary" onclick="showModal('image')">
                                Image
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="settingsModal" tabindex="-1" aria-labelledby="settingsModalLabel">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function showModal(group_key) {
            $.ajax({
                url: '{{ route('dawnstar.settings.modal') }}',
                data: {group_key},
                success: function (response) {
                    $('#settingsModal .modal-content').html(response);
                    var myModal = new bootstrap.Modal(document.getElementById('settingsModal'), {
                        keyboard: false
                    })
                    myModal.show();
                }
            })
        }
        function updateImage(quality = 90) {
            $.ajax({
                url: "{{ route('dawnstar.settings.image_quality') }}",
                data: {quality},
                method: "get",
                cache: false,
                success: function (result) {
                    $('#image').attr('src', result.image);
                    $('#image-size').html(result.size);
                    $('#image-quality').html(quality);
                }
            })
        }
    </script>
@endpush
