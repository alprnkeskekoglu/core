<div class="{{ $input['parent_class'] }}">
    @if($input['translation'] == 'true')
        @foreach($languages as $language)
            <div class="hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <label class="form-label">{{ $input['label'][$language->id] }}</label>
                <div class="mb-2">
                    @foreach($input['options'] as $value => $label)
                        <div class="form-check form-check-inline">
                            <input type="checkbox"
                                   id="{{ $input['id'][$language->id] . '_' . $value }}"
                                   name="{{ $input['name'][$language->id] }}[]"
                                   class="form-check-input {{ $input['class'] ?? '' }}  @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                                   value="{{ $value }}" {{ $input['value'][$language->id] == $value ? 'checked' : '' }}>
                            <label class="form-check-label" for="{{ $input['id'][$language->id] . '_' . $value }}">{{ $label }}</label>
                        </div>
                    @endforeach
                    @if($errors->has($input['key'][$language->id]))
                        <div class="invalid-feedback d-block">
                            {{ $errors->first($input['key'][$language->id]) }}
                        </div>
                    @enderror
                </div>
            </div>
        @endforeach
    @else
        <label class="form-label">{{ $input['label'] }}</label>
        <div class="mb-2">
            @foreach($input['options'] as $value => $label)
                <div class="form-check form-check-inline">
                    <input type="checkbox"
                           id="{{ $input['id'] . '_' . $value }}"
                           name="{{ $input['name'] }}[]"
                           class="form-check-input {{ $input['class'] ?? '' }} @error($input['name']) is-invalid @enderror"
                           value="{{ $value }}" {{ in_array($value, (is_array($input['value']) ? $input['value'] : [$input['value']])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $input['id'] . '_' . $value }}">{{ $label }}</label>
                </div>
            @endforeach
        </div>
        @error($input['name'])
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    @endif
</div>
