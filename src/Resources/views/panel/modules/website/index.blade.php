@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::website.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.websites.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::website.labels.status')</th>
                                <th>@lang('Dawnstar::website.labels.default')</th>
                                <th>@lang('Dawnstar::website.labels.name')</th>
                                <th>@lang('Dawnstar::website.labels.domain')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($websites as $website)
                                <tr>
                                    <th scope="row">{{ $website->id }}</th>
                                    <td>
                                        <span class="badge bg-{{ statusClass($website->status) }} font-16">{{ statusText($website->status) }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ statusClass($website->default) }} font-16">@lang('Dawnstar::general.' . ($website->default === 1 ? 'yes' : 'no'))</span>
                                    </td>
                                    <td>
                                        {{ $website->name }}
                                    </td>
                                    <td>{{ $website->domain }}</td>
                                    <td class="table-action">
                                        <a href="{{ route('dawnstar.websites.edit', $website) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        @if($website->default !== 1)
                                            <form action="{{ route('dawnstar.websites.destroy', $website) }}" method="POST" class="d-inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn action-icon"><i class="mdi mdi-delete"></i></button>
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
        <script>showMessage('success', '', '{{ session('success') }}')</script>
    @endif
@endpush
