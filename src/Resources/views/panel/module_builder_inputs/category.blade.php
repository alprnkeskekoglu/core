<div class="{{ $input['parent_class'] }}">
    <div class="form-floating mb-3">
        <select class="select2 form-select select2-multiple {{ $input['class'] ?? '' }} @error($input['name']) is-invalid @enderror"
                multiple
                name="{{ $input['name'] }}[]"
                data-type="category"
                data-placeholder="{{ __('Dawnstar::general.select') }}"
                id="{{ $input['id'] }}">
            @foreach($input['options'] as $value => $label)
                <option value="{{ $value }}" {{ in_array($value, $input['value']) ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        <label for="{{ $input['id'] }}">{{ $input['label'] }}</label>
        @error($input['name'])
        <div class="invalid-feedback">
            {{ $message }}
        </div>
        @enderror
    </div>
</div>

@once
    @push('scripts')
        <script>
            $('select[data-type="category"]').select2({
                language: '{{ session('dawnstar.language.code') }}',
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
