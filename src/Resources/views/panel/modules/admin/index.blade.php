@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::admin.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 text-end">
                        <a href="{{ route('dawnstar.admins.create') }}" class="btn btn-primary">
                            <i class="uil uil-plus me-1"></i>
                            @lang('Dawnstar::general.add_new')
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::admin.labels.status')</th>
                                <th>@lang('Dawnstar::admin.labels.avatar')</th>
                                <th>@lang('Dawnstar::admin.full_name')</th>
                                <th>@lang('Dawnstar::admin.labels.email')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($admins as $admin)
                                <tr>
                                    <th scope="row">{{ $admin->id }}</th>
                                    <td>
                                        <span class="badge bg-{{ statusClass($admin->status) }} font-14">{{ statusText($admin->status) }}</span>
                                    </td>
                                    <td>
                                        <img src="{{ media($admin->mf_avatar->id) }}" class="img-fluid avatar-md rounded-circle">
                                    </td>
                                    <td>
                                        {{ $admin->full_name }}
                                    </td>
                                    <td>{{ $admin->email }}</td>
                                    <td class="table-action">
                                        <a href="{{ route('dawnstar.admins.edit', $admin) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
                                        <form action="{{ route('dawnstar.admins.destroy', $admin) }}" method="POST" class="d-inline">
                                            @method('DELETE')
                                            @csrf
                                            <button type="submit" class="btn action-icon"><i class="mdi mdi-delete"></i></button>
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
        <script>$.NotificationApp.send("", "{{ session('success') }}", "bottom-right", "rgba(0,0,0,0.2)", "success")</script>
    @endif
@endpush
