@extends('Core::layouts.app')

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::admin_action.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Core::admin_action.labels.type')</th>
                                <th>@lang('Core::admin_action.labels.admin_id')</th>
                                <th>@lang('Core::admin_action.labels.model_type')</th>
                                <th>@lang('Core::admin_action.labels.model_id')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($actions as $action)
                                <tr>
                                    <th scope="row">{{ $action->id }}</th>
                                    <td>
                                        <span class="badge bg-{{ $action->type_color }} font-16">{{ $action->type_translation }}</span>
                                    </td>
                                    <td class="table-user">
                                        <img src="{{ media($action->admin->mf_avatar->id) }}" class="me-2 img-fluid avatar-md rounded-circle"/>
                                        {{ $action->admin->full_name }}
                                    </td>
                                    <td>{{ $action->model_type }}</td>
                                    <td>{{ $action->model_id }}</td>
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
