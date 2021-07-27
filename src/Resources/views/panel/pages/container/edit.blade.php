@extends('DawnstarView::layouts.app')

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
            <form action="{{ route('dawnstar.containers.update', $container) }}" method="POST">
                <input type="hidden" name="_method" value="PUT">
                @csrf
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <div>
                            <a href="{{ route('dawnstar.form_builders.edit', [$container, 'type' => 'container']) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                <i class="fa fa-sliders-h"></i>
                                {{ __('DawnstarLang::general.form_builder') }}
                            </a>
                        </div>
                        <div class="block-options">
                            @if($container->type == 'dynamic')
                                <a href="{{ route('dawnstar.containers.pages.index', $container) }}" class="btn btn-sm btn-outline-secondary">
                                    <i class="fa fa-arrow-left"></i>
                                    {{ __('DawnstarLang::general.go_back') }}
                                </a>
                            @endif
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
                                                <a class="nav-link {{ $loop->first ? 'active' : '' }}" href="#{{$language->code}}">
                                                    <img src="//flagcdn.com/24x18/{{ $language->code == 'en' ? 'gb' : $language->code }}.png" alt="{{ $language->code }}">
                                                    {{ $language->native_name . ' (' . strtoupper($language->code) . ')' }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <div class="block-content tab-content">
                                        @foreach($languages as $language)
                                            <div class="tab-pane {{ $loop->first ? 'active' : '' }}" id="{{$language->code}}" role="tabpanel">
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

@push('scripts')
    <script>
        var typingTimer;
        var doneTypingInterval = 500;
        var typedInput;

        @if($container->key != 'homepage')
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
        @endif
    </script>
@endpush
