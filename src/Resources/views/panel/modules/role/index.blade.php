@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::role.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.roles.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::role.labels.name')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <th scope="row">{{ $role->id }}</th>
                                    <td>{{ $role->name }}</td>
                                    <td class="table-action">
                                        @if($role->id != 1)
                                            <a href="{{ route('dawnstar.roles.edit', $role) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                            <form action="{{ route('dawnstar.roles.destroy', $role) }}" method="POST" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn action-icon">
                                                    <i class="mdi mdi-delete"></i>
                                                </button>
                                            </form>
                                        @endif
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
