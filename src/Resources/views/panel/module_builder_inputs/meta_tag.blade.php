<div id="metaTags">
    <div class="h4">
        Meta Tags
    </div>
    <div class="mb-4">

        @foreach($languages as $language)
            <div class="previewBox hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <div class="d-flex justify-content-center">
                    <div class="preview col-md-6 border border-2 mb-4 p-2 w-50">
                        <span class="text-dark slug" data-domain="{{ request()->root() . '/' . $language->code }}">{{ request()->root() . '/' . $language->code }}</span>
                        <button class="text-muted">▼</button>
                        <h2 class="title"></h2>
                        <span class="text-muted">{{ date('d M Y') }}</span> — <p class="d-inline description"></p>
                    </div>
                </div>

                <div class="row">
                    @foreach($tags as $tag)
                        <div class="col-lg-6">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control meta_tags"
                                       data-key="{{ $tag['key'] }}"
                                       id="meta_tags_{{$language->id}}_{{$tag['key']}}"
                                       name="meta_tags[{{ $language->id }}][{{$tag['key']}}]"
                                       value="{{ $tag['value'][$language->id] ?? '' }}"/>
                                <label for="meta_tags_{{$language->id}}_{{$tag['key']}}">{{ $tag['key'] }} ({{ strtoupper($language->code) }})</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>


@once
    @push('styles')
        <style>
            .preview {
                margin-left: 8px;
            }

            .preview h2 {
                font-size: 19px;
                line-height: 18px;
                font-weight: normal;
                color: rgb(29, 1, 189);
                margin-bottom: 5px;
                margin-top: 5px;
            }

            .preview button {
                font-size: 10px;
                line-height: 14px;
                margin-bottom: 0px;
                padding: 0px;
                border-width: 0px;
                background-color: white;
            }
        </style>
    @endpush
    @push('scripts')
        <script>
            $('.meta_tags').on('keyup', function () {
                var value = $(this).val();
                var key = $(this).attr('data-key');

                var box = $(this).closest('.previewBox');
                if(key == 'title') {
                    box.find('.title').html(value);
                } else if(key == 'description') {
                    box.find('.description').html(value);
                }
            });

            $('.slugInput').on('keyup', function () {
                var value = $(this).val();
                var language = $(this).attr('data-language');

                var slug = $('#metaTags').find('.previewBox[data-language="'+language+'"]').find('.slug');

                slug.html(slug.attr('data-domain') + value);
            })

            $('.meta_tags, .slugInput').trigger('keyup');
        </script>
    @endpush
@endonce
