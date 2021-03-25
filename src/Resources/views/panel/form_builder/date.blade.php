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
    <label class="d-block">{{ $labelText }}</label>
    <div class="form-group">
        <input type="text"
               {!! $inputAttributes !!}
               id="{{ $id }}"
               name="{{ $name }}"
               value="{{ old($name, $value) }}">
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ dawnstarAsset('plugins/flatpickr/flatpickr.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ dawnstarAsset('plugins/flatpickr/flatpickr.min.js') }}"></script>
        <script>
            $(".date").flatpickr();
        </script>
    @endpush
@endonce
