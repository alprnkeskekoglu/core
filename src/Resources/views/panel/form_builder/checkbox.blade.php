@php
    $id = $input['id'];
    $name = $input['name'] . (isset($input['multiple']) && $input['multiple'] ? '[]' : '');

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
    <div class="form-group row">
        @foreach($input['options'] as $option)
            <div class="col-md-3">
                <div class="custom-control custom-checkbox custom-control-lg custom-control-inline">
                    @if(isset($input['multiple']) && $input['multiple'])
                        <input type="checkbox" {!! $inputAttributes !!} id="{{ $id . '_' . $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ in_array($option['value'], old($input['name'], $value ?: [])) ? 'checked' : '' }}>
                    @else
                        <input type="checkbox" {!! $inputAttributes !!} id="{{ $id . '_' . $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ old($input['name'], $value) == $option['value'] ? 'checked' : '' }}>
                    @endif
                    <label class="custom-control-label" for="{{ $id . '_' . $option['value'] }}">{{ $option['text'][$dawnstarLanguageCode] ?? array_shift($option['text']) }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
