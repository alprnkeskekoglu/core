<div class="{{ $input['parent_class'] }}">
    @if($input['translation'])
        @foreach($languages as $language)
            <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <input type="{{ $input['type'] }}"
                       class="form-control {{ $input['class'] }}"
                       value="{{ $input['value'] }}"
                       id="{{ $input['id'] }}"/>
                <label for="{{ $input['id'] }}">{{ $input['labels'][$language->id] }}</label>
            </div>
        @endforeach
    @else
        <div class="form-floating mb-2">
            <input type="{{ $input['type'] }}"
                   class="form-control {{ $input['class'] }}"
                   value="{{ $input['value'] }}"
                   id="{{ $input['id'] }}"/>
            <label for="{{ $input['id'] }}">{{ $input['label'] }}</label>
        </div>
    @endif
</div>
