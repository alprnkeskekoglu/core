<div class="accordion custom-accordion" id="accordion">
    @foreach($customTranslations as $key => $customTranslation)
        <div class="card customTranslationBox mb-0">
            <div class="card-header" id="heading{{ $key }}">
                <h5 class="m-0">
                    <a class="custom-accordion-title collapsed d-block py-1" data-bs-toggle="collapse" href="#collapse{{ $key }}" aria-expanded="false" aria-controls="collapse{{ $key }}">
                        <div class="text-center">
                            <span class="start-0 position-absolute">{{ $key }}</span>
                            <span class="fw-normal">{{ $customTranslation['default_value'] ?? '' }}</span>
                        </div>
                    </a>

                    <div class="position-absolute end-0 me-2" style="top: 15px">
                        <button type="button" data-key="{{ $key }}" class="border-0 bg-transparent font-20 text-danger deleteBtn"><i class="mdi mdi-delete"></i></button>
                    </div>
                </h5>
            </div>
            <div id="collapse{{ $key }}" class="collapse" aria-labelledby="heading{{ $key }}" data-bs-parent="#accordion">
                <div class="card-body">
                    <div class="row">
                        @foreach($customTranslation['languages'] as $languageId => $content)
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label for="{{ $key . '_' . $languageId }}" class="form-label">
                                        <img class="rounded me-1" src="//flagcdn.com/h20/{{ $content['language_code'] }}.png">
                                        {{ $content['language_name'] }}
                                    </label>
                                    <input type="text" class="form-control languageInput"
                                           id="{{ $key . '_' . $languageId }}"
                                           value="{{ old($key . '.' . $languageId, $content['value']) }}"
                                           data-id="{{ $content['id'] }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
