@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::structure.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.structures.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Core::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Core::structure.labels.status')</th>
                                <th>@lang('Core::structure.labels.key')</th>
                                <th>@lang('Core::container.labels.name')</th>
                                <th>@lang('Core::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($structures as $structure)
                                <tr>
                                    <th scope="row">{{ $structure->id }}</th>
                                    <td>
                                        <span class="badge bg-{{ statusClass($structure->status) }} font-16">{{ statusText($structure->status) }}</span>
                                    </td>
                                    <td>
                                        <strong>{{ $structure->key }}</strong>
                                    </td>
                                    <td>
                                        {{ $structure->container->translation->name }}
                                    </td>
                                    <td class="table-action">
                                        <a href="{{ route('dawnstar.structures.edit', $structure) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('dawnstar.structures.destroy', $structure) }}" method="POST" class="d-inline">
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
