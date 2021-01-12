@php
    $id = $input['id'];
    $name = $input['name'];

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = $input['label']['text'][$dawnstarLanguageCode] ?? array_shift($input['label']['text']);

    $inputAttributes = '';
    if(isset($input['input']['attributes'])) {
        foreach ($input['input']['attributes'] as $tag => $attr) {
            $inputAttributes .= $tag.'="'.$attr.'" ';
        }
    }
@endphp

<div class="{{ $parentClass }}">
    <label class="d-block">{{ $labelText }}</label>
    <div class="form-group">
        <select {!! $inputAttributes !!} } multiple id="{{ $id }}" name="{{ $name }}">
            @foreach($input['categories'] as $id => $categoryName)
                <option {{ in_array($id, old($name, $value ?: [])) ? 'selected' : '' }} value="{{ $id }}">{{ $categoryName }}</option>
            @endforeach
        </select>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ dawnstarAsset('plugins/select2/css/select2.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ dawnstarAsset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $('.select2').select2({
                language: '{{ $dawnstarLanguageCode }}',
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
@endonce
