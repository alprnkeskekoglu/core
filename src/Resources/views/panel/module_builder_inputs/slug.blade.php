<div class="{{ $input['parent_class'] }}">
    @foreach($languages as $language)
        <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
            <input type="text"
                   class="form-control slugInput {{ $input['class'] ?? '' }} @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                   name="{{ $input['name'][$language->id] }}"
                   value="{{ $input['value'][$language->id] ?? '' }}"
                   id="{{ $input['id'][$language->id] }}" data-language="{{ $language->id }}"/>
            <label for="{{ $input['id'][$language->id] }}">{{ $input['label'][$language->id] }}</label>
            <div class="help-block text-muted ms-2">/{{ $language->code }}<span>/{{ ltrim(($input['value'][$language->id] ?? ''), '/') }}</span></div>
            @if($errors->has($input['key'][$language->id]))
                <div class="invalid-feedback">
                    {{ $errors->first($input['key'][$language->id]) }}
                </div>
            @endif
        </div>
    @endforeach
</div>
