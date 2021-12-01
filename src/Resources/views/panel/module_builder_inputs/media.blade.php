<div class="{{ $input['parent_class'] }}">
    @if($input['translation'] == 'true')
        @foreach($languages as $language)
            <div class="mediaBox hasLanguage {{ $loop->first ? '' : 'd-none' }}" data-language="{{ $language->id }}">
                <div class="mb-1">
                    <label class="form-label">{{ $input['label'][$language->id] }}</label>
                    <button type="button" class="btn btn-outline-info font-15 p-0 px-2 ms-5 mediaManagerBtn" title="Media Manager"
                            data-id="{{ $input['id'][$language->id] }}" data-maxcount="{{ $input['max_count'] ?? '' }}" data-selectable="{{ $input['selectable'] ?? 'image' }}">
                        <i class="mdi mdi-image-plus"></i>
                    </button>
                </div>
                <div class="mediaList d-flex justify-content-start">
                    @if(is_countable($input['value'][$language->id]) && count($input['value'][$language->id]) > 0)
                        @foreach($input['value'][$language->id] as $mediaId)
                            <div class="avatar-xl position-relative me-3" style="background-color: #efefef;">
                                <span class="avatar-title bg-light text-secondary rounded">
                                    <img src="{{ media($mediaId) }}" class="img-fluid mh-100 rounded">
                                </span>
                                <span class="d-block text-center text-muted">{{ \Str::limit(media($mediaId)->full_name, 12) }}</span>
                                <div class="d-grid end-0 mb-n1 me-n2 position-absolute bottom-0">
                                    <a href="javascript:void(0);" class="removeMediaBtn" data-id="{{ $mediaId }}">
                                        <span class="badge bg-white rounded-pill shadow-sm">
                                            <i class="font-14 mdi mdi-close text-danger"></i>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="avatar-xl position-relative" style="background-color: #efefef;">
                            <img src="https://via.placeholder.com/150" class="img-fluid mh-100 rounded">
                        </div>
                    @endif
                </div>
                <input type="hidden" name="{{ $input['name'][$language->id] }}" id="{{ $input['id'][$language->id] }}"
                       value="{{ implode(',', $input['value'][$language->id] ?? []) }}" data-language="{{ $language->id }}">
            </div>
        @endforeach
    @else
        <div class="mediaBox">
            <div class="mb-1">
                <label class="form-label">{{ $input['label'] }}</label>
                <button type="button" class="btn btn-outline-info font-15 p-0 px-2 ms-5 mediaManagerBtn" title="Media Manager"
                        data-id="{{ $input['column'] }}" data-maxcount="{{ $input['max_count'] ?? '' }}" data-selectable="{{ $input['selectable'] ?? 'image' }}">
                    <i class="mdi mdi-image-plus"></i>
                </button>
            </div>
            <div class="mediaList d-flex justify-content-start">
                @if(is_countable($input['value']) && count($input['value']) > 0)
                    @foreach($input['value'] as $mediaId)
                        <div class="avatar-xl position-relative me-3" style="background-color: #efefef;">
                            <span class="avatar-title bg-light text-secondary rounded">
                                <img src="{{ media($mediaId) }}" class="img-fluid mh-100 rounded">
                            </span>
                            <span class="d-block text-center text-muted">{{ \Str::limit(media($mediaId)->full_name, 12) }}</span>
                            <div class="d-grid end-0 mb-n1 me-n2 position-absolute bottom-0">
                                <a href="javascript:void(0);" class="removeMediaBtn" data-id="{{ $mediaId }}">
                            <span class="badge bg-white rounded-pill shadow-sm">
                                <i class="font-14 mdi mdi-close text-danger"></i>
                            </span>
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="avatar-xl position-relative" style="background-color: #efefef;">
                        <img src="https://via.placeholder.com/150" class="img-fluid mh-100 rounded">
                    </div>
                @endif
            </div>
            <input type="hidden" name="{{ $input['name'] }}" id="{{ $input['column'] }}" value="{{ implode(',', $input['value'] ?? []) }}">
        </div>
    @endif
</div>

@once
    @push('scripts')
        <script src="{{ asset('vendor/media-manager/assets/js/media-manager.js') }}"></script>
    @endpush
@endonce
