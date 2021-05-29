@extends('DawnstarView::layouts.app')
@section('content')
    <main id="main-container">
        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ $role->name . ' - ' . __('DawnstarLang::permission.index_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            <div class="block block-rounded">
                <form action="{{ route('dawnstar.roles.permissions.store', $role) }}" method="post">
                    @csrf
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div id="accordion" role="tablist" aria-multiselectable="true">
                            @foreach($websites as $website)
                                <div class="block block-rounded mb-3 websiteBlock">
                                    <div class="block-header block-header-default" role="tab" id="website_label{{ $website->id }}">
                                        <a class="font-w600 {{ $loop->first ? '' : 'show' }}" data-toggle="collapse" data-parent="#accordion" href="#website{{ $website->id }}"
                                           aria-expanded="{{ $loop->first ? 'false' : 'true' }}" aria-controls="website{{ $website->id }}">Website - {{ $website->name }}</a>
                                    </div>
                                    <div id="website{{ $website->id }}" class="collapse {{ $loop->first ? 'show' : '' }}" role="tabpanel" aria-labelledby="website_label{{ $website->id }}"
                                         data-parent="#accordion">
                                        <div class="block-content">
                                            <div class="form-group row">
                                                <label class="d-block col-md-3">Genel Yetki</label>
                                                <div class="col-md-8">
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-lg custom-control-success">
                                                        <input type="radio" class="custom-control-input generalPermission" id="website{{ $website->id }}_*_allow" name="permissions[website.{{ $website->id }}.*]" value="1" {{ $role->hasPermissionTo("website.{ $website->id }.*") ? 'checked' : '' }}>
                                                        <label class="custom-control-label" for="website{{ $website->id }}_*_allow">@lang('DawnstarLang::permission.allow')</label>
                                                    </div>
                                                    <div class="custom-control custom-radio custom-control-inline custom-control-lg custom-control-danger">
                                                        <input type="radio" class="custom-control-input generalPermission" id="website{{ $website->id }}_*_forbid" name="permissions[website.{{ $website->id }}.*]" value="0" {{ $role->hasPermissionTo("website.{ $website->id }.*") ? '' : 'checked' }}>
                                                        <label class="custom-control-label" for="website{{ $website->id }}_*_forbid">@lang('DawnstarLang::permission.forbid')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="{{ "accordion_website{$website->id}" }}" role="tablist" aria-multiselectable="true">

                                                <!-- Container Structure Start -->
                                                <div class="block block-rounded mb-1">
                                                    <div class="block-header block-header-default" role="tab" id="{{ "website{$website->id}_container_structure_label" }}">
                                                        <a class="font-w600" data-toggle="collapse" data-parent="#{{ "accordion_website{$website->id}" }}"
                                                           href="#{{ "website{$website->id}container_structure" }}" aria-expanded="false"
                                                           aria-controls="{{ "website{$website->id}container_structure" }}">@lang('DawnstarLang::container.index_title')</a>
                                                    </div>
                                                    <div id="{{ "website{$website->id}container_structure" }}" class="collapse" role="tabpanel"
                                                         aria-labelledby="{{ "website{$website->id}container_structure_label" }}" data-parent="#{{ "accordion_website{$website->id}" }}">
                                                        <div class="block-content">
                                                            @include('DawnstarView::pages.permission.partials.permission_types', [
                                                                    'key' => "website.{$website->id}.container_structure",
                                                                    'types' => ['index', 'edit', 'delete'],
                                                                    'icons' => ['index' => 'bars', 'edit' => 'edit', 'delete' => 'trash-alt']
                                                                    ])
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Container Structure End -->

                                                <!-- Menu Start -->
                                                <div class="block block-rounded mb-1">
                                                    <div class="block-header block-header-default" role="tab" id="{{ "website{$website->id}_menu_label" }}">
                                                        <a class="font-w600" data-toggle="collapse" data-parent="#{{ "accordion_website{$website->id}" }}" href="#{{ "website{$website->id}menu" }}"
                                                           aria-expanded="false" aria-controls="{{ "website{$website->id}menu" }}">@lang('DawnstarLang::menu.index_title')</a>
                                                    </div>
                                                    <div id="{{ "website{$website->id}menu" }}" class="collapse" role="tabpanel" aria-labelledby="{{ "website{$website->id}menu_label" }}"
                                                         data-parent="#{{ "accordion_website{$website->id}" }}">
                                                        <div class="block-content">
                                                            @include('DawnstarView::pages.permission.partials.permission_types', ['key' => "website.{$website->id}.menu"])
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Menu End -->

                                                <!-- Form Start -->
                                                <div class="block block-rounded mb-1">
                                                    <div class="block-header block-header-default" role="tab" id="{{ "website{$website->id}_form_label" }}">
                                                        <a class="font-w600" data-toggle="collapse" data-parent="#{{ "accordion_website{$website->id}" }}" href="#{{ "website{$website->id}form" }}"
                                                           aria-expanded="false" aria-controls="{{ "website{$website->id}form" }}">@lang('DawnstarLang::form.index_title')</a>
                                                    </div>
                                                    <div id="{{ "website{$website->id}form" }}" class="collapse" role="tabpanel" aria-labelledby="{{ "website{$website->id}form_label" }}"
                                                         data-parent="#{{ "accordion_website{$website->id}" }}">
                                                        <div class="block-content">
                                                            @include('DawnstarView::pages.permission.partials.permission_types', [
                                                                    'key' => "website.{$website->id}.form",
                                                                    'types' => ['index', 'create', 'edit', 'delete', 'results'],
                                                                    'icons' => ['index' => 'bars', 'create' => 'plus', 'edit' => 'edit', 'delete' => 'trash-alt', 'results' => 'comments']
                                                                    ])
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Form End -->

                                                <!-- Custom Content Start -->
                                                <div class="block block-rounded mb-1">
                                                    <div class="block-header block-header-default" role="tab" id="{{ "website{$website->id}_custom_content_label" }}">
                                                        <a class="font-w600" data-toggle="collapse" data-parent="#{{ "accordion_website{$website->id}" }}"
                                                           href="#{{ "website{$website->id}custom_content" }}" aria-expanded="false"
                                                           aria-controls="{{ "website{$website->id}custom_content" }}">@lang('DawnstarLang::custom_content.index_title')</a>
                                                    </div>
                                                    <div id="{{ "website{$website->id}custom_content" }}" class="collapse" role="tabpanel"
                                                         aria-labelledby="{{ "website{$website->id}custom_content_label" }}" data-parent="#{{ "accordion_website{$website->id}" }}">
                                                        <div class="block-content">
                                                            @include('DawnstarView::pages.permission.partials.permission_types', [
                                                                    'key' => "website.{$website->id}.custom_content",
                                                                    'types' => ['index', 'edit', 'delete'],
                                                                    ])
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Custom Content End -->

                                                <hr>

                                                <!-- Containers Start -->
                                                @foreach($containers[$website->id] as $container)
                                                    <div class="block block-rounded mb-1">
                                                        <div class="block-header block-header-default" role="tab" id="{{ "website{$website->id}_container{$container->id}_label" }}">
                                                            <a class="font-w600" data-toggle="collapse" data-parent="#{{ "accordion_website{$website->id}" }}"
                                                               href="#{{ "website{$website->id}container{$container->id}" }}" aria-expanded="false"
                                                               aria-controls="{{ "website{$website->id}container{$container->id}" }}">{!! $container->detail->name !!}</a>
                                                        </div>
                                                        <div id="{{ "website{$website->id}container{$container->id}" }}" class="collapse" role="tabpanel"
                                                             aria-labelledby="{{ "website{$website->id}container{$container->id}_label" }}" data-parent="#{{ "accordion_website{$website->id}" }}">
                                                            <div class="block-content">
                                                                @include('DawnstarView::pages.permission.partials.permission_types', ['key' => "website.{$website->id}.container.{$container->id}"])
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                                <!-- Containers End -->

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div class="block block-rounded mb-3">
                                <div class="block-header block-header-default" role="tab" id="admin_label">
                                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#admin" aria-expanded="false"
                                       aria-controls="admin">@lang('DawnstarLang::admin.index_title')</a>
                                </div>
                                <div id="admin" class="collapse" role="tabpanel" aria-labelledby="admin_label" data-parent="#accordion">
                                    <div class="block-content">
                                        @include('DawnstarView::pages.permission.partials.permission_types', ['key' => 'admin'])
                                    </div>
                                </div>
                            </div>
                            <div class="block block-rounded mb-3">
                                <div class="block-header block-header-default" role="tab" id="file_manager_label">
                                    <a class="font-w600" data-toggle="collapse" data-parent="#accordion" href="#file_manager" aria-expanded="false"
                                       aria-controls="file_manager">@lang('DawnstarLang::general.filemanager')</a>
                                </div>
                                <div id="file_manager" class="collapse" role="tabpanel" aria-labelledby="file_manager_label" data-parent="#accordion">
                                    <div class="block-content">
                                        @include('DawnstarView::pages.permission.partials.permission_types', ['key' => 'file_manager', 'types' => ['index']])
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $('.generalPermission').on('change', function () {
            var val = $(this).val();
            $(this).closest('.websiteBlock').find('input[value="'+val+'"]').prop('checked', true)
        })
    </script>
@endpush
