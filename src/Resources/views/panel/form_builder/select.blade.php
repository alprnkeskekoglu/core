@php
    $id = $input['id'];
    $isMultiple = isset($input['multiple']) && $input['multiple'];
    $name = $input['name'];

    $parentClass = $input['parent_class'] ?? 'col-md-6';
    $labelText = formBuilderLabel($input, $dawnstarLanguageCode);
    $inputAttributes = '';
    if(isset($input['input']['attributes'])) {
        foreach ($input['input']['attributes'] as $tag => $attr) {
            $inputAttributes .= $tag.'="'.$attr.'" ';
        }
    }

    $options = \Illuminate\Support\Facades\Cache::rememberForever($container->id . $type . $input['name'] . $dawnstarLanguageCode, function () use($input, $dawnstarLanguageCode) {
        $options = [];
        if($input['option_type'] == 'country') {
            $countries = \Dawnstar\Models\Country::all()->pluck('name_' . $dawnstarLanguageCode, 'id');
            foreach ($countries as $id => $country) {
                $options[] = ['value' => $id,'text' => [$dawnstarLanguageCode => $country]];
            }
        } elseif($input['option_type'] == 'city') {
            $cities = \Dawnstar\Models\City::query();
            if(isset($input['city_option']['country_id'])) {
                $cities = $cities->where('country_id', $input['city_option']['country_id']);
            }
            $cities = $cities->pluck('name', 'id');
            foreach ($cities as $id => $city) {
                $options[] = ['value' => $id,'text' => [$dawnstarLanguageCode => $city]];
            }
        } elseif($input['option_type'] == 'model') {
            $model = $input['model_option']['model'] == 'page' ? \Dawnstar\Models\Page::orderBy('order') : \Dawnstar\Models\Category::orderBy('lft');
            $models = $model->where('status', 1)->get();
            foreach ($models as $mod) {
                $options[] = ['value' => $mod->id,'text' => [$mod->detail->language->code => $mod->detail->name]];
            }
        } else {
            $options = $input['options'];
        }

        return $options;
    })
@endphp

<div class="{{ $parentClass }}">
    <label class="d-block">{{ $labelText }}</label>
    <div class="form-group">
        <select {!! $inputAttributes !!} {{ $isMultiple ? 'multiple' : '' }} data-type="select2" id="{{ $id }}" name="{{ $name }}">
            @if(!$isMultiple)
                <option value="">{{ __('DawnstarLang::general.select') }}</option>
            @endif
            @foreach($options as $option)
                @php
                    $isSelected = old($name, $value) == $option['value'];
                    if($isMultiple) {
                        $isSelected = in_array($option['value'], old($name, $value ?: []));
                    }
                @endphp
                <option {{ $isSelected ? 'selected' : '' }} value="{{ $option['value'] }}">{{ $option['text'][$dawnstarLanguageCode] ?? array_shift($option['text']) }}</option>
            @endforeach
        </select>
    </div>
</div>

@once
    @push('styles')
        <link rel="stylesheet" href="{{ dawnstarAsset('plugins/select2/css/select2.min.css') }}">
    @endpush
    @push('scripts')
        <script src="{{ dawnstarAsset('plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            $('select[data-type="select2"]').select2({
                language: '{{ $dawnstarLanguageCode }}',
                placeholder: '{{ __('DawnstarLang::general.select') }}',
                matcher: select2Search
            });

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
        </script>
    @endpush
@endonce
