<div class="{{ $input['parent_class'] }}">
    @foreach($languages as $language)
        <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
            <input type="text"
                   class="form-control slugInput {{ $input['class'] }}"
                   name="translations[{{ $language->id }}]{{ $input['name'] }}"
                   value="{{ $input['value'] }}"
                   id="translations_{{ $language->id }}_{{ $input['id'] }}" data-language="{{ $language->id }}"/>
            <label for="translations_{{ $language->id }}_{{ $input['id'] }}">{{ $input['labels'][session('dawnstar.language.id')] }}</label>
            <div class="help-block text-muted ms-2">/{{ $language->code }}<span>{{ $input['value'] }}</span></div>
        </div>
    @endforeach
</div>
