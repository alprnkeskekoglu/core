@php
    $id = $input['id'];
    $name = $input['name'];

    $parentClass = $input['parent_class'] ?? 'col-md-12';
    $labelText = $input['label']['text'][$dawnstarLanguageCode] ?? array_shift($input['label']['text']);

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
                <div class="input-group-prepend">
                    <span class="input-group-text">
                        {{ '/' . $tabLanguage->code . ($containerDetail ? $containerDetail->slug : '') }}
                    </span>
                </div>
                <input {!! $inputAttributes !!}
                       {!! $tabLanguage ? 'data-language="'.$tabLanguage->id.'"' : '' !!}
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
