@php
    $id = $input['id'];
    $name = $input['name'];

    $value = $value ?? [];

    $parentClass = $input['parent_class'] ?? 'col-md-12';
    $labelText = $input['label']['text'][$dawnstarLanguageCode] ?? array_shift($input['label']['text']);

    $maxMediaCount = $input['max_media_count'] ?? 1;
    $mediaType = $input['media_type'] ?? 'image';
@endphp


<div class="{{ $parentClass }}">
    <div class="form-group row">
        <div class="col-md-4">
            <label for="{{ $id }}">{{ $labelText }}</label>
        </div>
        <div class="col-md-6">
            <button type="button"
                    class="btn btn-sm btn-primary openFileManagerBtn"
                    data-id="{{ $id }}"
                    data-mediatype="{{ $mediaType }}"
                    data-selectabletype="{{ $mediaType }}"
                    data-maxmediacount="{{ $maxMediaCount }}">
                {{ __('DawnstarLang::general.filemanager') }}
            </button>
        </div>
    </div>
    <hr>
    <div class="block">
        <div class="mediaSlick" id="slick{{ $id }}">
            @foreach($value as $mediaId)
                @php($mediaArray = getMediaArray(media($mediaId)->model))
                <div class="px-1">
                    {!! $mediaArray['html'] !!}
                    <div class="font-size-sm text-muted">{{ $mediaArray['fullname'] }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ implode(',', $value) }}">
</div>

@once

    @push('styles')
        <link rel="stylesheet" href="{{ dawnstarAsset('plugins/slick-carousel/slick.css') }}">
        <link rel="stylesheet" href="{{ dawnstarAsset('plugins/slick-carousel/slick-theme.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ dawnstarAsset('plugins/slick-carousel/slick.min.js') }}"></script>
        <script>

            var currentMediaInputId;
            $('.openFileManagerBtn').on('click', function () {
                currentMediaInputId = $(this).attr('data-id');
                var _mediaType = $(this).attr('data-mediatype');
                var _selectableType = $(this).attr('data-selectabletype');
                var _maxMediaCount = $(this).attr('data-maxmediacount');
                var _selectedMediaIds = $('#' + currentMediaInputId).val();
                window.open(
                    '{{ route('dawnstar.filemanager.index') }}' + '/' + _mediaType + '?selectableType=' + _selectableType + '&maxMediaCount=' + _maxMediaCount + '&selectedMediaIds=' + _selectedMediaIds,
                    'Dawnstar File Manager', 'width=1520,height=740,left=200,top=100'
                );
            });


            $('.mediaSlick').slick({
                slidesToShow: 5,
                infinite: false,
                variableWidth: true
            });

            function handleFileManager(medias){
                var ids = '';
                var mediaHtml = '';

                $.each(medias, function (id, data) {
                    ids += id + ',';
                    mediaHtml += '<div class="px-1">' + data.html + '<div class="font-size-sm text-muted">'+ data.fullname +'</div></div>';
                });

                ids = ids.replace(/,\s*$/, "")

                $('.mediaSlick').slick('unslick');

                $('#' + currentMediaInputId).val(ids);
                $('#slick' + currentMediaInputId).html(mediaHtml);

                $('.mediaSlick').slick({
                    slidesToShow: 5,
                    infinite: false,
                    variableWidth: true
                });
            }
        </script>
    @endpush
@endonce
