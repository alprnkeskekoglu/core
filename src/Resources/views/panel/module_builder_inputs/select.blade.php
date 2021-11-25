<div class="{{ $input['parent_class'] }}">
    @if($input['translation'] == 'true')
        @foreach($languages as $language)
            <div class="form-floating hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <select class="select2 form-select {{ $input['type'] == 'multiple' ? 'select2-multiple' : '' }} @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                        {{ $input['type'] == 'multiple' ? 'multiple' : '' }}
                        name="{{ $input['name'][$language->id] . ($input['type'] == 'multiple' ? '[]' : '') }}"
                        data-type="select2"
                        id="{{ $input['id'][$language->id] }}">
                    @foreach($input['options'] as $value => $label)
                        <option value="{{ $value }}" {{ in_array($value, (is_array($input['value'][$language->id]) ? $input['value'][$language->id] : [$input['value'][$language->id]])) ? 'selected' : '' }}>{{ $label }}</option>
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
        <div class="form-floating mb-3">
            <select class="select2 form-select {{ $input['type'] == 'multiple' ? 'select2-multiple' : '' }} {{ $input['class'] ?? '' }} @error($input['name']) is-invalid @enderror"
                    {{ $input['type'] == 'multiple' ? 'multiple' : '' }}
                    name="{{ $input['name'] . ($input['type'] == 'multiple' ? '[]' : '') }}"
                    data-type="select2"
                    id="{{ $input['id'] }}">
                @foreach($input['options'] as $value => $label)
                    <option value="{{ $value }}" {{ in_array($value, (is_array($input['value']) ? $input['value'] : [$input['value']])) ? 'selected' : '' }}>{{ $label }}</option>
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

@once
    @push('scripts')
        <script>
            $('select[data-type="select2"]').select2({
                language: '{{ session('dawnstar.language.code') }}',
                placeholder: '{{ __('Dawnstar::general.select') }}',
                allowClear: true,
                matcher: select2Search
            });
            $('.select2-selection').addClass('form-select');

            function select2Search(params, data) {
                if ($.trim(params.term) === '') {
                    return data;
                }
                if (typeof data.text === 'undefined') {
                    return null;
                }

                var temp = data.text.toLowerCase();
                var searchTemp = params.term.toLowerCase();
                if (temp.indexOf(searchTemp) > -1) {
                    return $.extend({}, data, true);
                }
                return null;
            }
            @error('languages')
            $('.select2-selection--multiple').addClass('is-invalid').attr('style', 'border-color: #ff5b5b !important');
            @enderror
        </script>
    @endpush
@endonce
