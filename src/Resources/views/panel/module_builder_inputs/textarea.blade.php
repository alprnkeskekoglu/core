<div class="{{ $input['parent_class'] }}">
    @if($input['translation'])
        @foreach($languages as $language)
            <div class="form-floating mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <textarea class="form-control {{ $input['class'] }}"
                          name="translations[{{ $language->id }}]{{ $input['name'] }}"
                          id="translations_{{ $language->id }}_{{ $input['id'] }}"
                          style="resize: none; height: 100px">{{ $input['value'] }}</textarea>
                <label for="translations_{{ $language->id }}_{{ $input['id'] }}">{{ $input['labels'][session('dawnstar.language.id')] }}</label>
            </div>
        @endforeach
    @else
        <div class="form-floating mb-2">
                <textarea class="form-control {{ $input['class'] }}"
                          name="{{ $input['name'] }}"
                          id="{{ $input['id'] }}"
                          style="resize: none">{{ $input['value'] }}</textarea>
            <label for="{{ $input['id'] }}">{{ $input['labels'][session('dawnstar.language.id')] }}</label>
        </div>
    @endif
</div>
