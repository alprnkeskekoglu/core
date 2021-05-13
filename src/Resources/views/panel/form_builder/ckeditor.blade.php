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
        <textarea {!! $inputAttributes !!} data-editor="ckeditor" id="{{ $id }}" name="{{ $name }}">{{ old($name, $value) }}</textarea>
    </div>
</div>
@once
    @push('scripts')
        <script src="{{ dawnstarAsset('plugins/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ dawnstarAsset('plugins/ckeditor/lang/' . $dawnstarLanguageCode . '.js') }}"></script>
        <script>
            var editors = document.querySelectorAll('[data-editor="ckeditor"]');
            for (var i = 0; i < editors.length; ++i) {
                CKEDITOR.replace(editors[i], {
                    language: '{{ $dawnstarLanguageCode }}',
                });
            }

        </script>
    @endpush
@endonce
