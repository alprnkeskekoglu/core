@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::menu.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.menus.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::menu.labels.status')</th>
                                <th>@lang('Dawnstar::menu.labels.name')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($menus as $menu)
                            <tr>
                                <th scope="row">{{ $menu->id }}</th>
                                <td>
                                    <span class="badge bg-{{ statusClass($menu->status) }} font-16">{{ statusText($menu->status) }}</span>
                                </td>
                                <td>
                                    {{ $menu->name }}
                                </td>
                                <td class="table-action">
                                    <a href="{{ route('dawnstar.menus.edit', $menu) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                    <a href="{{ route('dawnstar.menus.items.index', $menu) }}" class="btn position-relative action-icon">
                                        <i class="mdi mdi-menu"></i>
                                    </a>
                                    <form action="{{ route('dawnstar.menus.destroy', $menu) }}" method="POST" class="d-inline">
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
                </div> <!-- end card-body -->
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
