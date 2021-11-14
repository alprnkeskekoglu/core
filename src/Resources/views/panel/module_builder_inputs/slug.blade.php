<div class="{{ $input['parent_class'] }}">
    @foreach($languages as $language)
        <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
            <input type="text"
                   class="form-control {{ $input['class'] }}"
                   value="{{ $input['value'] }}"
                   id="{{ $input['id'] }}"/>
            <label for="{{ $input['id'] }}">{{ $input['labels'][$language->id] }}</label>
            <div class="help-block text-muted ms-2">/{{ $language->code }}<span>{{ $input['value'] }}</span></div>
        </div>
    @endforeach
</div>
