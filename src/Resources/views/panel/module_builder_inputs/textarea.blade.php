<div class="{{ $input['parent_class'] }}">
    @if($input['translation'] == 'true')
        @foreach($languages as $language)
            <div class="@if($input['type'] == 'textarea') form-floating @endif mb-2 hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                @if($input['type'] == 'ckeditor')
                <label for="{{ $input['id'][$language->id] }}">{{ $input['label'][$language->id] }}</label>
                @endif
                <textarea class="form-control {{ $input['class'] ?? '' }} @if($errors->has($input['key'][$language->id])) is-invalid @endif"
                          name="{{ $input['name'][$language->id] }}"
                          id="{{ $input['id'][$language->id] }}"
                          data-type="{{ $input['type'] }}"
                          style="resize: none; height: 100px">{{ $input['value'][$language->id] ?? '' }}</textarea>
                @if($input['type'] == 'textarea')
                    <label for="{{ $input['id'][$language->id] }}">{{ $input['label'][$language->id] }}</label>
                @endif
                @if($errors->has($input['key'][$language->id]))
                    <div class="invalid-feedback">
                        {{ $errors->first($input['key'][$language->id]) }}
                    </div>
                @endif
            </div>
        @endforeach
    @else
        <div class="@if($input['type'] == 'textarea') form-floating @endif mb-2">
            @if($input['type'] == 'ckeditor')
                <label for="{{ $input['id'] }}">{{ $input['label'] }}</label>
            @endif
            <textarea class="form-control {{ $input['class'] ?? '' }} @error($input['name']) is-invalid @enderror"
                      name="{{ $input['name'] }}"
                      id="{{ $input['id'] }}"
                      style="resize: none">{{ $input['value'] }}</textarea>
            @if($input['type'] == 'textarea')
                    <label for="{{ $input['id'] }}">{{ $input['label'] }}</label>
            @endif
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
        <script src="{{ asset('vendor/dawnstar/assets/plugins/ckeditor/ckeditor.js') }}"></script>
        <script src="{{ asset('vendor/dawnstar/assets/plugins/ckeditor/lang/' . session('dawnstar.language.code') . '.js') }}"></script>
        <script>
            var editors = document.querySelectorAll('textarea[data-type="ckeditor"]');
            for (var i = 0; i < editors.length; ++i) {
                CKEDITOR.replace(editors[i], {
                    language: '{{ session('dawnstar.language.code') }}',
                    filebrowserImageBrowseUrl: '/dawnstar/media-manager?selectable=image&maxCount=1',
                    filebrowserBrowseUrl: '/dawnstar/media-manager?selectable=image&maxCount=1',
                    toolbar: [
                        {
                            name: 'clipboard',
                            groups: ['clipboard', 'undo'],
                            items: ['PasteFromWord', '-', 'Undo', 'Redo']
                        },
                        {
                            name: 'editing',
                            groups: ['find', 'selection', 'spellchecker'],
                            items: ['Find', 'Replace']
                        },
                        {
                            name: 'paragraph',
                            groups: ['list', 'indent', 'blocks', 'align', 'bidi'],
                            items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'textindent', '-', 'Blockquote', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                        },
                        {name: 'insert', items: ['Image', 'Table', 'bol', 'SpecialChar', 'Iframe']},
                        {name: 'links', items: ['Link', 'Unlink']},
                        '/',
                        {
                            name: 'basicstyles',
                            groups: ['basicstyles', 'cleanup'],
                            items: ['Bold', 'Italic', 'Underline', 'Strike', '-', 'Subscript', 'Superscript', '-', 'RemoveFormat']
                        },
                        {name: 'styles', items: ['Styles', 'Format', 'FontSize']},
                        {name: 'colors', items: ['TextColor', 'BGColor']},
                        {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                        {name: 'document', groups: ['mode', 'document', 'doctools'], items: ['Source', 'kopyala']}

                    ]
                });
            }
        </script>
    @endpush
@endonce
