@php
    $id = str_replace('.', '_', $input['name']);
    $isMultiple = isset($input['multiple']) && $input['multiple'];
    $name = $input['name'] . ($isMultiple ? '[]' : '');

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = $input['label']['text'][$languageCode] ?? array_shift($input['label']['text']);

    $inputAttributes = '';
    foreach ($input['input']['attributes'] as $tag => $value) {
        $inputAttributes .= $tag.'="'.$value.'" ';
    }
@endphp

<div class="{{ $parentClass }}">
    <label class="d-block">{{ $labelText }}</label>
    <div class="form-group">
        <select class="form-control select2" {{ $isMultiple ? 'multiple' : '' }} id="{{ $id }}" name="{{ $name }}">
            @if(!$isMultiple)
                <option value="">{{ __('DawnstarLang::general.select') }}</option>
            @endif
            @foreach($input['options'] as $option)
                <option value="{{ $option['value'] }}">{{ $option['text'][$languageCode] ?? array_shift($option['text']) }}</option>
            @endforeach
        </select>
    </div>
</div>

@push('styles')
    <link rel="stylesheet" href="{{ dawnstarAsset('plugins/select2/css/select2.min.css') }}">
@endpush
@push('scripts')
    <script src="{{ dawnstarAsset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $('.select2').select2({
            language: '{{ $languageCode }}',
            placeholder: '{{ __('DawnstarLang::general.select') }}',
            matcher: select2Search
        });

        function select2Search(params, data) {
            if ($.trim(params.term) === '') {
                return data;
            }
            if (typeof data.text === 'undefined') {
                return null;
            }

            var temp = data.text.toLowerCase();
            var searchTemp = params.term.toLowerCase();
            if (temp.indexOf(searchTemp) > -1) {
                return $.extend({}, data, true);
            }
            return null;
        }
    </script>
@endpush
