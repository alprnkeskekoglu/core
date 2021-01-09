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
    <div class="form-group">
        <label for="{{ $id }}">{{ $labelText }}</label>
        <textarea {!! $inputAttributes !!} data-editor="ckeditor" id="{{ $id }}" name="{{ $name }}">{{ old($name, $value) }}</textarea>
    </div>
</div>

@once
    @push('scripts')
        <script src="{{ dawnstarAsset('plugins/ckeditor/build/ckeditor.js') }}"></script>
        <script>
            var editors = document.querySelectorAll('[data-editor="ckeditor"]');
            for (var i = 0; i < editors.length; ++i) {
                ClassicEditor.create(editors[i]);
            }
        </script>
    @endpush
@endonce
