@extends('DawnstarView::layouts.app')

@php($image = $admin->mf_image ? getMediaArray($admin->mf_image) : null)
@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::admin.edit_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.profiles.update') }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default block-header-rtl">
                        <div class="block-options">
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
                                        @if($image)
                                            <div class="px-1 text-center">
                                                {!! $image['html'] !!}
                                                <div class="font-size-sm text-muted">{!! $image['fullname'] !!}</div>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="hidden" name="image" id="admin_image" value="{{ isset($image) ? $image['id'] : '' }}">
                                </div>
                            </div>
                            <div class="col-sm-10 col-md-8">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::admin.labels.fullname') }}</label>
                                            <input type="text" class="form-control" id="fullname" name="fullname" value="{{ old('fullname', $admin->fullname) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="key">{{ __('DawnstarLang::admin.labels.username') }}</label>
                                            <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $admin->username) }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">{{ __('DawnstarLang::admin.labels.email') }}</label>
                                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email', $admin->email) }}">
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
