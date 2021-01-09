@php
    $name = $input['name'];
    $id = str_replace('.', '_', $name);

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = $input['label']['text'][$languageCode] ?? array_shift($input['label']['text']);

    $inputAttributes = '';
    foreach ($input['input']['attributes'] as $tag => $value) {
        $inputAttributes .= $tag.'="'.$value.'" ';
    }
@endphp

<div class="{{ $parentClass }}">
    <div class="form-group">
        <label class="d-block">{{ $labelText }}</label>
        @foreach($input['options'] as $option)
            <div class="custom-control custom-radio custom-control-inline custom-control-{{ $option['color'] ?? 'primary' }} custom-control-lg">
                <input type="radio" {!! $inputAttributes !!} id="{{ $name . '_' . $option['value'] }}" name="{{ $name }}" value="{{ $option['value'] }}" {{ old($name) == $option['value'] ? 'checked' : '' }}>
                <label class="custom-control-label" for="{{ $name . '_' . $option['value'] }}">{{ $option['text'][$languageCode] ?? array_shift($option['text']) }}</label>
            </div>
        @endforeach
    </div>
</div>
