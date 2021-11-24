<div class="{{ $input['parent_class'] }}">
    @if($input['translation'] == 'true')
        @foreach($languages as $language)
            <div class="form-floating hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <select class="form-select {{ $input['class'] ?? '' }} @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                        name="{{ $input['name'][$language->id] }}"
                        id="{{ $input['id'][$language->id] }}">
                    <option value="">@lang('Dawnstar::general.select')</option>
                    @foreach($input['options'] as $value => $label)
                        <option value="{{ $value }}" {{ $input['value'][$language->id] == $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <label for="{{ $input['id'][$language->id] }}">{{ $input['label'] }}</label>
                @if($errors->has($input['key'][$language->id]))
                <div class="invalid-feedback">
                    {{ $errors->first($input['key'][$language->id]) }}
                </div>
                @endif
            </div>
        @endforeach
    @else

        <div class="form-floating">
            <select class="form-select {{ $input['class'] ?? '' }} @error($input['name']) is-invalid @enderror"
                    name="{{ $input['name'] }}"
                    id="{{ $input['id'] }}">
                <option value="">@lang('Dawnstar::general.select')</option>
                @foreach($input['options'] as $value => $label)
                    <option value="{{ $value }}" {{ $input['value'] == $value ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            <label for="{{ $input['id'] }}">{{ $input['label'] }}</label>
            @error($input['name'])
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    @endif
</div>
