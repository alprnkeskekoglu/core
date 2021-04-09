@php
    $id = $input['id'];
    $name = $input['name'];

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = formBuilderLabel($input, $dawnstarLanguageCode);

    $inputAttributes = '';
    if(isset($input['input']['attributes'])) {
        foreach ($input['input']['attributes'] as $tag => $attr) {
            $inputAttributes .= $tag.'="'.$attr.'" ';
        }
    }
@endphp

<div class="{{ $parentClass }}">
    <div class="form-group">
        <label class="d-block">{{ $labelText }}</label>
        @foreach($input['options'] as $option)
            <div class="custom-control custom-radio custom-control-inline custom-control-{{ $option['color'] ?? 'primary' }} custom-control-lg">
                <input type="radio" {!! $inputAttributes !!} id="{{ $name . '_' . $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ old($name, $value) == $option['value'] ? 'checked' : '' }}>
                <label class="custom-control-label" for="{{ $name . '_' . $option['value'] }}">{{ $option['text'][$dawnstarLanguageCode] ?? array_shift($option['text']) }}</label>
            </div>
        @endforeach
    </div>
</div>
