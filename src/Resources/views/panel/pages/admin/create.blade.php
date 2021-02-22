@extends('DawnstarView::layouts.app')

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::admin.create_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.admins.store') }}" method="POST">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
                            <a href="{{ route('dawnstar.admins.index') }}" class="btn btn-sm btn-outline-secondary">
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
                                <div class="form-group row">
                                    <div class="col-md-8">
                                        <label for="menu_image">{{ __('DawnstarLang::admin.labels.image') }}</label>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" class="btn btn-sm btn-primary openFileManagerBtn" data-id="admin_image" data-mediaType="image" data-selectabletype="image" data-maxmediacount="1">
                                            {{ __('DawnstarLang::general.filemanager') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="block">
                                    <div id="show_admin_image">
                                    </div>
                                    <input type="hidden" name="image" id="admin_image">
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-8">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="d-block">{{ __('DawnstarLang::admin.labels.status') }}</label>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-success custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="status_active" name="status" value="1" {{ old('status') == 1 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_active">{{ __('DawnstarLang::general.status_title.active') }}</label>
                                            </div>
                                            <div class="custom-control custom-radio custom-control-inline custom-control-danger custom-control-lg">
                                                <input type="radio" class="custom-control-input" id="status_passive" name="status" value="3" {{ old('status') == 3 ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="status_passive">{{ __('DawnstarLang::general.status_title.passive') }}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::admin.labels.role_id') }}</label>

                                            <select class="form-control" id="role_id" name="role_id">
                                                <option value="">{{ __('DawnstarLang::general.select') }}</option>
                                                <option value="1" {{ old('role_id') == 1 ? 'selected' : '' }}>Super Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::admin.labels.fullname') }}</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="key">{{ __('DawnstarLang::admin.labels.username') }}</label>
                                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::admin.labels.email') }}</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="key">{{ __('DawnstarLang::admin.labels.password') }}</label>
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
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

@push('scripts')
    <script>
        var currentMediaInputId;
        $('.openFileManagerBtn').on('click', function () {
            currentMediaInputId = $(this).attr('data-id');
            var _mediaType = $(this).attr('data-mediaType');
            var _selectableType = $(this).attr('data-selectableType');
            var _maxMediaCount = $(this).attr('data-maxMediaCount');
            var _selectedMediaIds = $('#' + currentMediaInputId).val();
            window.open(
                '{{ route('dawnstar.filemanager.index') }}' + '/' + _mediaType + '?selectableType=' + _selectableType + '&maxMediaCount=' + _maxMediaCount + '&selectedMediaIds=' + _selectedMediaIds,
                'Dawnstar File Manager', 'width=1520,height=740,left=200,top=100'
            );
        });


        function handleFileManager(medias){
            var ids = '';
            var mediaHtml = '';

            $.each(medias, function (id, data) {
                ids += id + ',';
                mediaHtml += '<div class="px-1 text-center">' + data.html + '<div class="font-size-sm text-muted">'+ data.fullname +'</div></div>';
            });

            ids = ids.replace(/,\s*$/, "")

            $('#' + currentMediaInputId).val(ids);
            $('#show_' + currentMediaInputId).html(mediaHtml);
        }
    </script>
@endpush
