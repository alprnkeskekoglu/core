<div class="{{ $input['parent_class'] }}">
    @if($input['translation'] == 'true')
        @foreach($languages as $language)
            <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <textarea class="form-control {{ $input['class'] ?? '' }} @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                          name="{{ $input['name'][$language->id] }}"
                          id="{{ $input['id'][$language->id] }}"
                          style="resize: none; height: 100px">{{ $input['value'][$language->id] ?? '' }}</textarea>
                <label for="{{ $input['id'][$language->id] }}">{{ $input['label'][$language->id] }}</label>
                @if($errors->has($input['key'][$language->id]))
                    <div class="invalid-feedback">
                        {{ $errors->first($input['key'][$language->id]) }}
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="form-floating mb-2">
                <textarea class="form-control {{ $input['class'] ?? '' }} @error($input['name']) is-invalid @enderror"
                          name="{{ $input['name'] }}"
                          id="{{ $input['id'] }}"
                          style="resize: none">{{ $input['value'] }}</textarea>
            <label for="{{ $input['id'] }}">{{ $input['label'] }}</label>
            @error($input['name'])
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    @endif
</div>
