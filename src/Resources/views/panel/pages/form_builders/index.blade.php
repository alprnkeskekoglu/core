@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::container.index_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <div class="block-content">
                    <table class="table table-striped table-vcenter">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 50px;">#</th>
                            <th>{{ __('DawnstarLang::container.name') }}</th>
                            <th class="text-center" style="width: 100px;">{{ __('DawnstarLang::general.actions') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($formBuilders as $formBuilder)
                            <tr>
                                <th class="text-center" scope="row">
                                    {{ $formBuilder->id }}
                                </th>
                                <td class="font-w600 fa-1x">
                                    {{ $formBuilder->container->detail->name . ' - ' . $formBuilder->type }}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('dawnstar.form_builders.edit', ['id' => $formBuilder->container_id, 'type' => $formBuilder->type]) }}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="bottom" title="{{ __('DawnstarLang::general.edit') }}">
                                            <i class="fa fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
