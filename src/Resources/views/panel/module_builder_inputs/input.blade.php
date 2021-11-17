<div class="{{ $input['parent_class'] }}">
    @if($input['translation'])
        @foreach($languages as $language)
            <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <input type="{{ $input['type'] }}"
                       class="form-control {{ strstr($input['name'], '[name]') != false ? 'nameInput' : '' }} {{ $input['class'] }}"
                       name="translations[{{ $language->id }}]{{ $input['name'] }}"
                       value="{{ $input['value'] }}"
                       id="translations_{{ $language->id }}_{{ $input['id'] }}" data-language="{{ $language->id }}"/>
                <label for="translations_{{ $language->id }}_{{ $input['id'] }}">{{ $input['labels'][session('dawnstar.language.id')] }}</label>
            </div>
        @endforeach
    @else
        <div class="form-floating mb-2">
            <input type="{{ $input['type'] }}"
                   class="form-control {{ $input['class'] }}"
                   name="{{ $input['name'] }}"
                   value="{{ $input['value'] }}"
                   id="{{ $input['id'] }}"/>
            <label for="{{ $input['id'] }}">{{ $input['labels'][session('dawnstar.language.id')] }}</label>
        </div>
    @endif
</div>
