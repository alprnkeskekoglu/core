@php
    $id = $input['id'];
    $name = $input['name'];

    $value = $value ?? [];

    $parentClass = $input['parent_class'] ?? 'col-md-12';
    $labelText = formBuilderLabel($input, $dawnstarLanguageCode);

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
        <ul class="medias d-flex list-unstyled" id="main_{{ $id }}">
            @foreach($value as $mediaId)
                @php($mediaArray = getMediaArray(media($mediaId)->model))
                <li class="px-3 ui-state-default">
                    {!! $mediaArray['html'] !!}
                    <div class="font-size-sm text-muted">{{ $mediaArray['fullname'] }}</div>
                    <input type="hidden" name="{{ $name }}[]" value="{{ $mediaId }}">
                </li>
            @endforeach
        </ul>
    </div>

</div>

@once
    @push('scripts')
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            var currentMediaInputId;
            $('.openFileManagerBtn').on('click', function () {
                currentMediaInputId = $(this).attr('data-id');
                var _mediaType = $(this).attr('data-mediatype');
                var _selectableType = $(this).attr('data-selectabletype');
                var _maxMediaCount = $(this).attr('data-maxmediacount');

                var _selectedMediaIds = '';
                $('input[name="medias['+currentMediaInputId+'][]"]').each(function() {
                    _selectedMediaIds += $(this).val() + ',';
                });
                _selectedMediaIds = _selectedMediaIds.replace(/,\s*$/, "");

                window.open(
                    '{{ route('dawnstar.filemanager.index') }}' + '/' + _mediaType + '?selectableType=' + _selectableType + '&maxMediaCount=' + _maxMediaCount + '&selectedMediaIds=' + _selectedMediaIds,
                    'Dawnstar File Manager', 'width=1520,height=740,left=200,top=100'
                );
            });


            $('.medias').sortable({
                revert: true
            });
            $(".medias").disableSelection();

            function handleFileManager(medias) {
                var mediaHtml = '';
                $.each(medias, function (index, data) {
                    mediaHtml += '<div class="px-3">' + data.html + '<div class="font-size-sm text-muted">' + data.fullname + '</div><input type="hidden" name="medias['+currentMediaInputId+'][]" value="'+data.id+'"></div>';
                });

                $('#main_' + currentMediaInputId).html(mediaHtml);

                $('.medias').sortable({
                    revert: true
                });
                $(".medias").disableSelection();
            }
        </script>
    @endpush
@endonce
