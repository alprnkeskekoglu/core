@extends('DawnstarView::layouts.app')

@php
    $activeLanguageIds = $category->details->pluck('language_id')->toArray();
@endphp

@section('content')
    <main id="main-container">

        <div class="content content-max-width">
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <h1 class="flex-sm-fill font-size-h2 font-w400 mt-2 mb-0 mb-sm-2">{{ __('DawnstarLang::container.edit_title') }}</h1>
                @include('DawnstarView::layouts.breadcrumb')
            </div>
        </div>

        <div class="content">
            @include('DawnstarView::layouts.alerts')
            <form action="{{ route('dawnstar.containers.categories.update', [$container, $category]) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <div>
                            <a href="{{ route('dawnstar.form_builders.edit', [$container, 'type' => 'category']) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-sliders-h"></i>
                                {{ __('DawnstarLang::general.form_builder') }}
                            </a>
                        </div>
                        <div class="block-options">
                            <a href="{{ route('dawnstar.containers.categories.index', $container) }}" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-arrow-left"></i>
                                {{ __('DawnstarLang::general.go_back') }}
                            </a>
                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                <i class="fa fa-check"></i>
                                {{ __('DawnstarLang::general.submit') }}
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row justify-content-center py-sm-3 py-md-5">
                            <div class="col-sm-10 col-md-8">
                                <div class="row">
                                    {!! $formBuilder->render() !!}
                                </div>
                                <div class="mt-4">
                                    <ul class="nav nav-tabs nav-tabs-alt w-100" data-toggle="tabs" role="tablist">
                                        @foreach($languages as $language)
                                            <li class="nav-item">
                                                <a class="nav-link {{ in_array($language->id, $activeLanguageIds) ? '' : 'disabled' }}" href="#{{$language->code}}">
                                                    <img src="//flagcdn.com/24x18/{{ $language->code == 'en' ? 'gb' : $language->code }}.png" alt="{{ $language->code }}">
                                                    {{ $language->native_name . ' (' . strtoupper($language->code) . ')' }}
                                                    <i class="fa {{ in_array($language->id, $activeLanguageIds) ? 'fa-times text-danger' : 'fa-plus text-success' }} ml-3 detailStatusBtn" data-languageId="{{ $language->id }}" data-languageCode="{{ $language->code }}"
                                                       data-target="{{ in_array($language->id, $activeLanguageIds) ? 3 : 1 }}"></i>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="block-content tab-content">
                                        @foreach($languages as $language)
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{$language->code}}" role="tabpanel">
                                                <input type="hidden" name="details[{{ $language->id }}][status]" id="details_{{ $language->id }}_status" value="{{ in_array($language->id, $activeLanguageIds) ? '1' : '2' }}">
                                                <div class="row mb-5">
                                                    {!! $formBuilder->render($language) !!}
                                                </div>

                                                <h2 class="content-heading">{{ __('DawnstarLang::general.meta_tags') }}</h2>
                                                <div class="block-content bg-gray-light">
                                                    <div class="row">
                                                        {!! $formBuilder->metas($language) !!}
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
            </form>
        </div>
    </main>
@endsection

@push('styles')
    <style>
        .nav-link.disabled > i {
            pointer-events: all;
            cursor: pointer;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var typingTimer;
        var doneTypingInterval = 500;
        var typedInput;

        $('body').delegate('[id$="_name"]', 'keyup', function () {
            clearTimeout(typingTimer);
            typedInput = $(this);
            var languageId = typedInput.attr('data-language');

            if(typedInput.val().length) {
                typingTimer = setTimeout(slugify, doneTypingInterval);
            } else {
                $('[id$="_slug"][data-language="' + languageId + '"]').val('');
            }
        });

        $('body').delegate('[id$="_name"]', 'keydown', function () {
            clearTimeout(typingTimer);
        });


        slugify = function () {
            var text = typedInput.val();
            var map = {
                'çÇ': 'c',
                'ğĞ': 'g',
                'şŞ': 's',
                'üÜ': 'u',
                'ıİ': 'i',
                'öÖ': 'o'
            };
            for (var key in map) {
                text = text.replace(new RegExp('[' + key + ']', 'g'), map[key]);
            }
            var slug = '/' + text.replace(/[^-a-zA-Z0-9\s]+/ig, '')
                .replace(/\s/gi, "-")
                .replace(/[-]+/gi, "-")
                .toLowerCase();

            var languageId = typedInput.attr('data-language');
            var name = typedInput.val();

            $.ajax({
                'url': '{{ route('dawnstar.containers.getUrl') }}',
                'data': {'language_id': languageId, 'url': slug, 'name': name},
                'method': 'GET',
                success: function (response) {
                    $('[id$="_slug"][data-language="' + languageId + '"]').val(response);
                },
            });
        }

        $('a.nav-link:not(.disabled):first').tab('show');
        $('body').delegate('.detailStatusBtn', 'click', function (e) {
            var languageId = $(this).attr('data-languageId');
            var languageCode = $(this).attr('data-languageCode');
            var target = $(this).attr('data-target');
            var element = $(this).closest('a.nav-link');
            var isActive = element.hasClass('active');

            $('#details_' + languageId + '_status').val(target);

            if (target == 3) {
                element.addClass('disabled');
                $(this).attr('data-target', 1).toggleClass('text-danger').toggleClass('fa-times').toggleClass('text-success').toggleClass('fa-plus');

                $('a.nav-link:not(.disabled):first').tab('show');
            } else if (target == 1) {
                element.removeClass('disabled');
                $(this).attr('data-target', 3).toggleClass('text-danger').toggleClass('fa-times').toggleClass('text-success').toggleClass('fa-plus');

                element.tab('show');
            }

            $('.detailStatusBtn').unbind('click');
        })
    </script>
@endpush
