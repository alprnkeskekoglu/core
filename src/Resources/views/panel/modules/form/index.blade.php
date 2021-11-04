@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::form.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.forms.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::form.labels.status')</th>
                                <th>@lang('Dawnstar::form.labels.name')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($forms as $form)
                                <tr>
                                    <th scope="row">{{ $form->id }}</th>
                                    <td>
                                        <span class="badge bg-{{ statusClass($form->status) }} font-16">{{ statusText($form->status) }}</span>
                                    </td>
                                    <td>
                                        {{ $form->name }}
                                    </td>
                                    <td class="table-action">
                                        <a href="{{ route('dawnstar.forms.edit', $form) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        <a href="{{ route('dawnstar.forms.messages.index', $form) }}" class="btn position-relative action-icon">
                                            <i class="mdi mdi-message"></i>
                                            @if($form->messages_count > 0)
                                                <span class="position-absolute translate-middle badge rounded-pill bg-danger start-100 top-0" style="font-size: 11px;">
                                                    {{ $form->messages_count > 99 ? '99+' : $form->messages_count }}
                                                </span>
                                            @endif
                                        </a>
                                        <form action="{{ route('dawnstar.forms.destroy', $form) }}" method="POST" class="d-inline">
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @if(session('success'))
        <script>
            showMessage('success', '', '{{ session('success') }}')
        </script>
    @endif
@endpush
