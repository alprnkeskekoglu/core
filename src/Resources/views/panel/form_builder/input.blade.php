@php
    $id = $input['id'];
    $name = $input['name'];

    $parentClass = $input['parent_class'] ?? 'col-md-12';
    $labelText = formBuilderLabel($input, $dawnstarLanguageCode);

    $input['input']['attributes']['type'] = $input['input']['attributes']['type'] ?? 'text';

    $inputAttributes = '';
    foreach ($input['input']['attributes'] as $tag => $attr) {
        $inputAttributes .= $tag.'="'.$attr.'" ';
    }
@endphp




<div class="{{ $parentClass }}">
    <div class="form-group">
        <label for="{{ $id }}">{{ $labelText }}</label>
        @if(strpos($input['id'], 'slug') != false)
            @php
                $containerDetail = $container->details()->where('language_id', $tabLanguage->id)->first();
            @endphp
            <div class="input-group">
                @if(session('dawnstar.website.default_language_code') == 1 || $type != 'container')
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        {{ (session('dawnstar.website.default_language_code') == 1 ? '/' . $tabLanguage->code : '') . ($type != 'container' && $containerDetail ? $containerDetail->slug : '') }}
                    </span>
                </div>
                @endif
                <input {!! $inputAttributes !!}
                       {!! $tabLanguage ? 'data-language="'.$tabLanguage->id.'"' : '' !!}
                       {!! $container->key == 'homepage' ? 'readonly' : '' !!}
                       id="{{ $id }}"
                       name="{{ $name }}"
                       value="{{ old($name, $value) }}">
            </div>
        @else
            <input {!! $inputAttributes !!}
                   {!! $tabLanguage ? 'data-language="'.$tabLanguage->id.'"' : '' !!}
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old($name, $value) }}">
        @endif
    </div>
</div>
