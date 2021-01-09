@php
    $name = $input['name'];
    $id = str_replace('.', '_', $name);

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = $input['label']['text'][$languageCode] ?? array_shift($input['label']['text']);

    $input['input']['attributes']['type'] = $input['attributes']['type'] ?? 'text';

    $inputAttributes = '';
    foreach ($input['input']['attributes'] as $tag => $value) {
        $inputAttributes .= $tag.'="'.$value.'" ';
    }
@endphp

<div class="{{ $parentClass }}">
    <div class="form-group">
        <label for="{{ $id }}">{{ $labelText }}</label>
        <input {!! $inputAttributes !!} id="{{ $id }}" name="{{ $name }}" value="{{ old($name) }}">
    </div>
</div>
