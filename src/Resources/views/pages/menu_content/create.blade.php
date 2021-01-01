@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-full">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::menu_content.create_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('menu.content.store', ['menuId' => $menu->id]) }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('menu.index') }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i>
                                {{ __('DawnstarLang::general.go_back') }}
                            </a>
                            <button type="reset" class="btn btn-sm btn-outline-danger">
                                <i class="fa fa-sync"></i>
                                {{ __('DawnstarLang::general.refresh') }}
                            </button>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-md-4">
                                <div class="js-nestable-connected-simple dd">
                                    <ol class="dd-list">
                                        <li class="dd-item" data-id="1">
                                            <div class="dd-handle">Bootstrap</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="2">
                                                    <div class="dd-handle">Themes</div>
                                                </li>
                                                <li class="dd-item" data-id="3">
                                                    <div class="dd-handle">Documentation</div>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="dd-item" data-id="4">
                                            <div class="dd-handle">Learning</div>
                                            <ol class="dd-list">
                                                <li class="dd-item" data-id="5">
                                                    <div class="dd-handle">Code</div>
                                                </li>
                                                <li class="dd-item" data-id="6">
                                                    <div class="dd-handle">Tutorials</div>
                                                </li>
                                                <li class="dd-item" data-id="7">
                                                    <div class="dd-handle">Articles</div>
                                                </li>
                                            </ol>
                                        </li>
                                        <li class="dd-item" data-id="8">
                                            <div class="dd-handle">Design</div>
                                        </li>
                                        <li class="dd-item" data-id="9">
                                            <div class="dd-handle">Coding</div>
                                        </li>
                                        <li class="dd-item" data-id="10">
                                            <div class="dd-handle">Marketing</div>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                            <div class="col-md-6 offset-md-2">

                                <ul class="nav nav-tabs nav-tabs-alt" data-toggle="tabs" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" href="#btabs-alt-static-home">Home</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#btabs-alt-static-profile">Profile</a>
                                    </li>
                                </ul>
                                <div class="block-content tab-content">
                                    <div class="tab-pane active" id="btabs-alt-static-home" role="tabpanel">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">{{ __('DawnstarLang::menu_content.labels.status') }}</label>
                                            <div class="col-sm-9">
                                                <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                    <input type="radio" class="custom-control-input" id="status_active" name="status" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline custom-control-light custom-control-lg">
                                                    <input type="radio" class="custom-control-input" id="status_draft" name="status" value="2" {{ old('status', 2) == 2 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status_draft">{{ __('DawnstarLang::general.status_title.draft') }}</label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                    <input type="radio" class="custom-control-input" id="status_passive" name="status" value="3" {{ old('status') == 3 ? 'checked' : '' }}>
                                                    <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="name">{{ __('DawnstarLang::menu_content.labels.name') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label" for="type">{{ __('DawnstarLang::menu_content.labels.type') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="type" name="type">
                                                    <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                    <option value="1" {{ old('type') == 1 ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.type.internal_link') }}</option>
                                                    <option value="2" {{ old('type') == 2 ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.type.out_link') }}</option>
                                                    <option value="3" {{ old('type') == 3 ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.type.blank_link') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-none">
                                            <label class="col-sm-3 col-form-label" for="url_id">{{ __('DawnstarLang::menu_content.labels.url_id') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="url_id" name="url_id">
                                                    <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row d-none">
                                            <label class="col-sm-3 col-form-label" for="out_link">{{ __('DawnstarLang::menu_content.labels.out_link') }}</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="out_link" name="out_link" value="{{ old('out_link') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row d-none">
                                            <label class="col-sm-3 col-form-label" for="target">{{ __('DawnstarLang::menu_content.labels.target') }}</label>
                                            <div class="col-sm-9">
                                                <select class="form-control" id="target" name="target">
                                                    <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                    <option value="_blank" {{ old('target') == '_blank' ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.target.blank') }}</option>
                                                    <option value="_self" {{ old('target') == '_self' ? 'selected' : '' }}>{{ __('DawnstarLang::menu_content.target.self') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="btabs-alt-static-profile" role="tabpanel">
                                        <h4 class="font-w400">Profile Content</h4>
                                        <p>...</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ dawnstarAsset('plugins/nestable2/jquery.nestable.min.js') }}"></script>
    <script>
        $(".js-nestable-connected-simple").nestable({maxDepth:3})

        $('#type').on('change', function () {
            var value = $(this).val();

            if(value == 1) {
                $('#url_id').closest('.form-group').removeClass('d-none');
                $('#out_link').closest('.form-group').addClass('d-none');
                $('#target').closest('.form-group').removeClass('d-none');
            } else if(value == 2) {
                $('#url_id').closest('.form-group').addClass('d-none');
                $('#out_link').closest('.form-group').removeClass('d-none');
                $('#target').closest('.form-group').removeClass('d-none');

            } else {
                $('#url_id').closest('.form-group').addClass('d-none');
                $('#out_link').closest('.form-group').addClass('d-none');
                $('#target').closest('.form-group').addClass('d-none');
            }
        })
    </script>
@endpush
