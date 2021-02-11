@php
    $id = $input['id'];
    $name = $input['name'];

    $parentClass = $input['parent_class'] ?? 'col-md-12';
    $labelText = $input['type'];
@endphp


<div class="col-md-12">
    <div class="form-group row">
        <label class="col-md-3" for="{{ $id }}">{{ $labelText }}</label>
        <div class="col-md-9">
            <input class="form-control"
                   {!! $tabLanguage ? 'data-language="'.$tabLanguage->id.'"' : '' !!}
                   id="{{ $id }}"
                   name="{{ $name }}"
                   value="{{ old($name, $meta ? $meta->value : '') }}">
        </div>
    </div>
</div>
