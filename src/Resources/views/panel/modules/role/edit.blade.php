@extends('Core::layouts.app')

@php
    $types = ['index', 'create', 'edit', 'destroy'];
@endphp

@section('content')
    @include('Core::includes.page_header',['headerTitle' => __('Core::role.title.create')])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('dawnstar.roles.index') }}" class="btn btn-secondary">
                        <i class="mdi mdi-arrow-left"></i>
                        @lang('Core::general.back')
                    </a>
                </div>

                <div class="card-body">
                    <form action="{{ route('dawnstar.roles.update', $role) }}" id="roleUpdate" method="POST">
                        @method('PUT')
                        @csrf
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $role->name) }}"/>
                                    <label for="name">@lang('Core::role.labels.name')</label>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="accordion custom-accordion" id="accordion">
                                    <!-- Admin Start -->
                                    <div class="card mb-0">
                                        <div class="card-header" id="adminHeader">
                                            <h5 class="m-0">
                                                <a class="custom-accordion-title d-block py-1" data-bs-toggle="collapse" href="#adminCollapse" aria-expanded="true" aria-controls="adminCollapse">
                                                    Admin
                                                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="adminCollapse" class="collapse show" aria-labelledby="adminHeader" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                @foreach($types as $type)
                                                    <div class="row">
                                                        <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                        <div class="mb-3 col-lg-9">
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input type="radio" id="admin_{{ $type }}_1" name="permissions[admin.{{ $type }}]" class="form-check-input" value="1" {{ isset($permissions["admin.{$type}"]) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="admin_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-danger">
                                                                <input type="radio" id="admin_{{ $type }}_0" name="permissions[admin.{{ $type }}]" class="form-check-input" value="0" {{ isset($permissions["admin.{$type}"]) ? '' : 'checked' }}>
                                                                <label class="form-check-label" for="admin_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Admin End -->

                                    <!-- Role Start -->
                                    <div class="card mb-0">
                                        <div class="card-header" id="roleHeader">
                                            <h5 class="m-0">
                                                <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#roleCollapse" aria-expanded="false" aria-controls="roleCollapse">
                                                    Role
                                                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="roleCollapse" class="collapse" aria-labelledby="roleHeader" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                @foreach($types as $type)
                                                    <div class="row">
                                                        <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                        <div class="mb-3 col-lg-9">
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input type="radio" id="role_{{ $type }}_1" name="permissions[role.{{ $type }}]" class="form-check-input" value="1" {{ isset($permissions["role.{$type}"]) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="role_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-danger">
                                                                <input type="radio" id="role_{{ $type }}_0" name="permissions[role.{{ $type }}]" class="form-check-input" value="0" {{ isset($permissions["role.{$type}"]) ? '' : 'checked' }}>
                                                                <label class="form-check-label" for="role_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Role End -->

                                    <!-- Form Start -->
                                    <div class="card mb-0">
                                        <div class="card-header" id="formHeader">
                                            <h5 class="m-0">
                                                <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#formCollapse" aria-expanded="false" aria-controls="formCollapse">
                                                    Form
                                                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="formCollapse" class="collapse" aria-labelledby="formHeader" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                @foreach($types as $type)
                                                    <div class="row">
                                                        <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                        <div class="mb-3 col-lg-9">
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input type="radio" id="form_{{ $type }}_1" name="permissions[form.{{ $type }}]" class="form-check-input" value="1" {{ isset($permissions["form.{$type}"]) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="form_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-danger">
                                                                <input type="radio" id="form_{{ $type }}_0" name="permissions[form.{{ $type }}]" class="form-check-input" value="0" {{ isset($permissions["form.{$type}"]) ? '' : 'checked' }}>
                                                                <label class="form-check-label" for="form_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Form End -->

                                    <!-- Custom Translation Start -->
                                    <div class="card mb-0">
                                        <div class="card-header" id="customTranslationHeader">
                                            <h5 class="m-0">
                                                <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#customTranslationCollapse" aria-expanded="false" aria-controls="customTranslationCollapse">
                                                    Custom Translation
                                                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                </a>
                                            </h5>
                                        </div>

                                        <div id="customTranslationCollapse" class="collapse" aria-labelledby="customTranslationHeader" data-bs-parent="#accordion">
                                            <div class="card-body">
                                                @foreach($types as $type)
                                                    @continue(in_array($type, ['create']))
                                                    <div class="row">
                                                        <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                        <div class="mb-3 col-lg-9">
                                                            <div class="form-check form-check-inline form-radio-success">
                                                                <input type="radio" id="custom_translation_{{ $type }}_1" name="permissions[custom_translation.{{ $type }}]" class="form-check-input" value="1" {{ isset($permissions["custom_translation.{$type}"]) ? 'checked' : '' }}>
                                                                <label class="form-check-label" for="custom_translation_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                            </div>
                                                            <div class="form-check form-check-inline form-radio-danger">
                                                                <input type="radio" id="custom_translation_{{ $type }}_0" name="permissions[custom_translation.{{ $type }}]" class="form-check-input" value="0" {{ isset($permissions["custom_translation.{$type}"]) ? '' : 'checked' }}>
                                                                <label class="form-check-label" for="custom_translation_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Custom Translation End -->

                                    <!-- Website Start -->
                                    @foreach($websites as $website)
                                        <div class="card mb-0">
                                            <div class="card-header" id="website{{ $website->id }}Header">
                                                <h5 class="m-0">
                                                    <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#website{{ $website->id }}Collapse" aria-expanded="false" aria-controls="website{{ $website->id }}Collapse">
                                                        Website ({{ $website->name }})
                                                        <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                    </a>
                                                </h5>
                                            </div>

                                            <div id="website{{ $website->id }}Collapse" class="collapse" aria-labelledby="website{{ $website->id }}Header" data-bs-parent="#accordion">
                                                <div class="card-body">
                                                    @foreach($types as $type)
                                                        <div class="row">
                                                            <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                            <div class="mb-3 col-lg-9">
                                                                <div class="form-check form-check-inline form-radio-success">
                                                                    <input type="radio" id="website_{{ $website->id }}_{{ $type }}_1"
                                                                           name="permissions[website.{{ $website->id }}.{{ $type }}]"
                                                                           class="form-check-input" value="1"
                                                                        {{ isset($permissions["website.{$website->id}.{$type}"]) ? 'checked' : '' }}>
                                                                    <label class="form-check-label" for="website_{{ $website->id }}_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                                </div>
                                                                <div class="form-check form-check-inline form-radio-danger">
                                                                    <input type="radio" id="website_{{ $website->id }}_{{ $type }}_0"
                                                                           name="permissions[website.{{ $website->id }}.{{ $type }}]"
                                                                           class="form-check-input" value="0"
                                                                        {{ isset($permissions["website.{$website->id}.{$type}"]) ? '' : 'checked' }}>
                                                                    <label class="form-check-label" for="website_{{ $website->id }}_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="accordion custom-accordion" id="accordion0">
                                                                <div class="card mb-0">
                                                                    <div class="card-header" id="menuHeader">
                                                                        <h5 class="m-0">
                                                                            <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#menuCollapse" aria-expanded="false" aria-controls="menuCollapse">
                                                                                Menu
                                                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                            </a>
                                                                        </h5>
                                                                    </div>

                                                                    <div id="menuCollapse" class="collapse" aria-labelledby="menuHeader" data-bs-parent="#accordion0">
                                                                        <div class="card-body">
                                                                            @foreach($types as $type)
                                                                                <div class="row">
                                                                                    <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                                                    <div class="mb-3 col-lg-9">
                                                                                        <div class="form-check form-check-inline form-radio-success">
                                                                                            <input type="radio" id="website_{{ $website->id }}_menu_{{ $type }}_1" name="permissions[{{ "website.{$website->id}.menu.{$type}" }}]" class="form-check-input"
                                                                                                   value="1" {{ isset($permissions["website.{$website->id}.menu.{$type}"]) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="website_{{ $website->id }}_menu_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline form-radio-danger">
                                                                                            <input type="radio" id="website_{{ $website->id }}_menu_{{ $type }}_0" name="permissions[{{ "website.{$website->id}.menu.{$type}" }}]" class="form-check-input"
                                                                                                   value="0" {{ isset($permissions["website.{$website->id}.menu.{$type}"]) ? '' : 'checked' }}>
                                                                                            <label class="form-check-label" for="website_{{ $website->id }}_menu_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="card mb-0">
                                                                    <div class="card-header" id="structureHeader">
                                                                        <h5 class="m-0">
                                                                            <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#structureCollapse" aria-expanded="false" aria-controls="structureCollapse">
                                                                                Structure
                                                                                <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                            </a>
                                                                        </h5>
                                                                    </div>

                                                                    <div id="structureCollapse" class="collapse" aria-labelledby="structureHeader" data-bs-parent="#accordion0">
                                                                        <div class="card-body">
                                                                            @foreach($types as $type)
                                                                                <div class="row">
                                                                                    <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                                                    <div class="mb-3 col-lg-9">
                                                                                        <div class="form-check form-check-inline form-radio-success">
                                                                                            <input type="radio" id="website_{{ $website->id }}_structure_{{ $type }}_1" name="permissions[{{ "website.{$website->id}.structure.{$type}" }}]" class="form-check-input"
                                                                                                   value="1" {{ isset($permissions["website.{$website->id}.structure.{$type}"]) ? 'checked' : '' }}>
                                                                                            <label class="form-check-label" for="website_{{ $website->id }}_structure_{{ $type }}_1">@lang('Core::general.status_options.1')</label>
                                                                                        </div>
                                                                                        <div class="form-check form-check-inline form-radio-danger">
                                                                                            <input type="radio" id="website_{{ $website->id }}_structure_{{ $type }}_0" name="permissions[{{ "website.{$website->id}.structure.{$type}" }}]" class="form-check-input"
                                                                                                   value="0" {{ isset($permissions["website.{$website->id}.structure.{$type}"]) ? '' : 'checked' }}>
                                                                                            <label class="form-check-label" for="website_{{ $website->id }}_structure_{{ $type }}_0">@lang('Core::general.status_options.0')</label>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="accordion custom-accordion" id="accordion{{ $website->id }}">


                                                                @foreach($website->structures as $structure)
                                                                    <div class="card mb-0">
                                                                        <div class="card-header" id="{{ $structure->key }}Header">
                                                                            <h5 class="m-0">
                                                                                <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#{{ $structure->key }}Collapse" aria-expanded="false" aria-controls="{{ $structure->key }}Collapse">
                                                                                    {{ $structure->container->translation->name }}
                                                                                    <i class="mdi mdi-chevron-down accordion-arrow"></i>
                                                                                </a>
                                                                            </h5>
                                                                        </div>

                                                                        <div id="{{ $structure->key }}Collapse" class="collapse" aria-labelledby="{{ $structure->key }}Header" data-bs-parent="#accordion{{ $website->id }}">
                                                                            <div class="card-body">
                                                                                @foreach($types as $type)
                                                                                    @continue($structure->type != 'dynamic' && in_array($type, ['index', 'create', 'destroy']))
                                                                                    <div class="row">
                                                                                        <label class="form-label col-lg-3">@lang('Core::role.types.' . $type)</label>
                                                                                        <div class="mb-3 col-lg-9">
                                                                                            <div class="form-check form-check-inline form-radio-success">
                                                                                                <input type="radio" id="{{ $structure->key . '_' . $type }}_1" name="permissions[{{ "website.{$website->id}.structure.{$structure->id}.{$type}" }}]" class="form-check-input"
                                                                                                       value="1" {{ isset($permissions["website.{$website->id}.structure.{$structure->id}.{$type}"]) ? 'checked' : '' }}>
                                                                                                <label class="form-check-label" for="{{ $structure->key . '_' . $type }}_1">@lang('Core::general.status_options.1')</label>
                                                                                            </div>
                                                                                            <div class="form-check form-check-inline form-radio-danger">
                                                                                                <input type="radio" id="{{ $structure->key . '_' . $type }}_0" name="permissions[{{ "website.{$website->id}.structure.{$structure->id}.{$type}" }}]" class="form-check-input"
                                                                                                       value="0" {{ isset($permissions["website.{$website->id}.structure.{$structure->id}.{$type}"]) ? '' : 'checked' }}>
                                                                                                <label class="form-check-label" for="{{ $structure->key . '_' . $type }}_0">@lang('Core::general.status_options.0')</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                @endforeach
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                <!-- Website End -->
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary" form="roleUpdate">@lang('Core::general.save')</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('scripts')
    @if($errors->any())
        <script>
            showMessage('error', 'Oops...', '')
        </script>
    @endif
@endpush
