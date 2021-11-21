<div class="{{ $input['parent_class'] }}">
    @if($input['translation'])
        @foreach($languages as $language)
            <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <input type="{{ $input['type'] }}"
                       class="form-control {{ strstr($input['name'][$language->id], '[name]') != false ? 'nameInput' : '' }} {{ $input['class'] }} @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                       name="{{ $input['name'][$language->id] }}"
                       value="{{ $input['value'][$language->id] }}"
                       id="{{ $input['id'][$language->id] }}" data-language="{{ $language->id }}"/>
                <label for="{{ $input['id'][$language->id] }}">{{ $input['labels'][$language->id] }}</label>
                @if($errors->has($input['key'][$language->id]))
                    <div class="invalid-feedback">
                        {{ $errors->first($input['key'][$language->id]) }}
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="form-floating mb-2">
            <input type="{{ $input['type'] }}"
                   class="form-control {{ $input['class'] }} @error($input['name']) is-invalid @enderror"
                   name="{{ $input['name'] }}"
                   value="{{ $input['value'] }}"
                   id="{{ $input['id'] }}"/>
            <label for="{{ $input['id'] }}">{{ $input['labels'][$language->id] }}</label>
            @error($input['name'])
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    @endif
</div>
