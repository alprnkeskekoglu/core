@extends('Dawnstar::layouts.app')

@section('content')
    @include('Dawnstar::includes.page_header',['headerTitle' => __('Dawnstar::admin.title.index')])

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered mb-0">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>@lang('Dawnstar::module_builder.labels.structure')</th>
                                <th>@lang('Dawnstar::module_builder.labels.type')</th>
                                <th>@lang('Dawnstar::general.actions')</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($moduleBuilders as $moduleBuilder)
                                <tr>
                                    <th scope="row">{{ $moduleBuilder->id }}</th>
                                    <td>
                                        {{ $moduleBuilder->structure->container->translation->name }}
                                    </td>
                                    <td>
                                        <strong>{{ $moduleBuilder->type }}</strong>
                                    </td>
                                    <td class="table-action">
                                        <a href="{{ route('dawnstar.module_builders.edit', $moduleBuilder) }}" class="action-icon"> <i class="mdi mdi-pencil"></i></a>
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
