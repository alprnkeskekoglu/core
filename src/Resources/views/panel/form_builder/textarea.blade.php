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
        <label for="{{ $id }}">{{ $labelText }}</label>
        <textarea {!! $inputAttributes !!} id="{{ $id }}" name="{{ $name }}" style="resize: none">{{ old($name, $value) }}</textarea>
    </div>
</div>

