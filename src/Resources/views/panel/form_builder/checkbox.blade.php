@php
    $id = str_replace('.', '_', $input['name']);
    $name = $input['name'] . (isset($input['multiple']) && $input['multiple'] ? '[]' : '');

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = $input['label']['text'][$languageCode] ?? array_shift($input['label']['text']);

    $inputAttributes = '';
    foreach ($input['input']['attributes'] as $tag => $value) {
        $inputAttributes .= $tag.'="'.$value.'" ';
    }
@endphp

<div class="{{ $parentClass }}">
    <label class="d-block">{{ $labelText }}</label>
    <div class="form-group row">
        @foreach($input['options'] as $option)
            <div class="col-md-3">
                <div class="custom-control custom-checkbox custom-control-lg custom-control-inline">
                    @if(isset($input['multiple']) && $input['multiple'])
                        <input type="checkbox" {!! $inputAttributes !!} id="{{ $id . '_' . $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ in_array($option['value'], old($input['name'], [])) ? 'checked' : '' }}>
                    @else
                        <input type="checkbox" {!! $inputAttributes !!} id="{{ $id . '_' . $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ old($input['name']) == $option['value'] ? 'checked' : '' }}>
                    @endif
                    <label class="custom-control-label" for="{{ $id . '_' . $option['value'] }}">{{ $option['text'][$languageCode] ?? array_shift($option['text']) }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
