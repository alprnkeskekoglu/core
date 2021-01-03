<div id="accordion" class="mb-3" role="tablist" aria-multiselectable="true">
    @foreach($customContents as $key => $content)
        <div class="block block-rounded mb-1">
            <div class="block-header block-header-default" role="tab" id="accordion_{{ $loop->iteration }}">
                <a class="font-w600 w-100 accordionBtn"
                   data-toggle="collapse"
                   data-parent="#accordion"
                   href="#accordion_q{{ $loop->iteration }}"
                   aria-expanded="true"
                   aria-controls="accordion_q{{ $loop->iteration }}">
                    <div class="row">
                        <div class="col-md-4">{{ $key }}</div>
                        <div class="col-md-7">{{ $content['default_value'] }}</div>
                        <div class="col-md-1"><i class="fa fa-chevron-down float-right"></i></div>
                    </div>
                </a>
            </div>
            <div id="accordion_q{{ $loop->iteration }}" class="collapse" role="tabpanel" aria-labelledby="accordion_{{ $loop->iteration }}" data-parent="#accordion">

                <div class="block-content">
                    <div class="row">
                        @foreach($content['languages'] as $languageId => $language)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $language['language_name'] . ' (' . strtoupper($language['language_code']) . ')' }}</label>
                                    <input type="text"
                                           class="form-control languageInput"
                                           name="{{$key . '[' . $languageId . ']' }}"
                                           value="{{ old($key . '.' . $languageId, $language['value']) }}"
                                           data-key="{{ $key }}"
                                           data-language="{{ $languageId }}">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
