@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::form.title.index')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dawnstar.forms.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        @lang('Dawnstar::general.back')
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-sm mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::form_message.labels.read')</th>
                                <th>@lang('Dawnstar::form_message.labels.email')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($messages as $message)
                                <tr class="{{ $loop->iteration % 2 == 1 ? '' : 'bg-light' }}">
                                    <th scope="row">{{ $message->id }}</th>
                                    <td>
                                        <i class="mdi mdi-18px mdi-circle {{ $message->read == 1 ? 'text-success' : 'text-danger' }}"></i>
                                    </td>
                                    <td>
                                        {{ $message->email }}
                                    </td>
                                    <td class="table-action">
                                        <button type="button" class="btn position-relative action-icon showBtn" data-url="{{ route('dawnstar.forms.messages.show', [$form, $message]) }}">
                                            <i class="mdi mdi-eye"></i>
                                        </button>
                                        <form action="{{ route('dawnstar.forms.messages.destroy', [$form, $message]) }}" method="POST" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn action-icon">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>

    <div id="showModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="showModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            </div>
        </div>
    </div>
@endsection

@push('scripts')

    <script>
        @if(session('success'))
        showMessage('success', '', '{{ session('success') }}')
        @endif

        $('.showBtn').on('click', function () {
            var url = $(this).data('url');

            $.ajax({
                url: url,
                success: function (response) {
                    $('#showModal .modal-content').html(response);

                    var showModal = new bootstrap.Modal(document.getElementById('showModal'))
                    showModal.show()
                }
            })
        });
    </script>
@endpush
