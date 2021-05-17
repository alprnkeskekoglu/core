<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ ucwords($element['type']) }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body pb-1">
            <form action="{{ route('dawnstar.form_builders.saveElement') }}" id="elementForm" method="POST">
                @csrf
                <input type="hidden" name="formBuilder" value="{{ $formBuilder->id }}">
                <input type="hidden" name="type" value="{{ $element['type'] }}">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="key">Key</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="key" name="key">
                            <option value="general" {{ isset($key) && $key == 'general' ? 'selected' : '' }}>Genel</option>
                            <option value="languages" {{ isset($key) && $key == 'languages' ? 'selected' : '' }}>Dile Bağlı</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="parent_class">Parent Class</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="parent_class" name="parent_class" value="{{ $element['parent_class'] ?? 'col-md-12' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="name">Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="name" name="name" value="{{ $element['name'] ?? '' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Label</label>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="label_tr" name="label[text][tr]" placeholder="tr..." value="{{ formBuilderLabel($element, 'tr') }}">
                    </div>
                    <div class="col-sm-5">
                        <input type="text" class="form-control" id="label_en" name="label[text][en]" placeholder="en..." value="{{ formBuilderLabel($element, 'en') }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="multiple">Multiple</label>
                    <div class="col-sm-2 ">
                        <input type="hidden" name="multiple" value="0">
                        <input type="checkbox" class="form-control form-control-sm" id="multiple" name="multiple" value="1" {{ $element['multiple'] ?? 0 == 1 ? 'checked' : '' }}>
                    </div>
                </div>
                <h2 class="content-heading">Input</h2>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="attr_class">Class</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="attr_class" name="input[attributes][class]" value="{{ $element['attributes']['class'] ?? 'form-control' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="option_type">Seçenek Tipi</label>
                    <div class="col-sm-10">
                        <select id="option_type" name="option_type" class="form-control">
                            <option value="">Seçiniz</option>
                            <option value="country" {{ isset($element['option_type']) && $element['option_type'] == 'country' ? 'selected' : '' }}>Ülkeler</option>
                            <option value="city" {{ isset($element['option_type']) && $element['option_type'] == 'city' ? 'selected' : '' }}>Şehirler</option>
                            <option value="model" {{ isset($element['option_type']) && $element['option_type'] == 'model' ? 'selected' : '' }}>Model</option>
                            <option value="custom" {{ isset($element['option_type']) && $element['option_type'] == 'custom' ? 'selected' : '' }}>Custom</option>
                        </select>
                    </div>
                </div>


                <div id="cityOption" class="d-none">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Ülke</label>
                        <div class="col-sm-10">
                            <select id="city_option" name="city_option[country_id]" class="form-control optionInput">
                                <option value="">Seçiniz</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div id="modelOption" class="d-none">
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Model Type & ID</label>
                        <div class="col-sm-7">
                            <select name="model_option[model]" class="form-control optionInput">
                                <option value="">Seçiniz</option>
                                <option value="page" {{ isset($element['option']['model']) && $element['option']['model'] == 'page' ? 'selected' : '' }}>Page</option>
                                <option value="category" {{ isset($element['option']['model']) && $element['option']['model'] == 'category' ? 'selected' : '' }}>Category</option>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="number" class="form-control optionInput" name="model_option[id]" value="{{ $element['option']['id'] ?? '' }}">
                        </div>
                    </div>
                </div>
                <div id="customOption" class="d-none">
                    <h2 class="content-heading">Options
                        <button class="btn bg-black-10" id="copyOptionBtn"><i class="fa fa-plus"></i></button>
                    </h2>
                    <div class="options">
                        @foreach($element['options'] as $key => $option)
                            <div class="optionDiv" data-count="{{$key}}">
                                <button class="btn btn-sm btn-danger" onclick="removeOption(this)"><i class="fa fa-trash"></i></button>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Label TR</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control optionInput" id="option_label_tr" name="options[{{$key}}][text][tr]" placeholder="tr..."
                                                       value="{{ $option['text']['tr'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Label EN</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control optionInput" id="option_label_en" name="options[{{$key}}][text][en]" placeholder="en..."
                                                       value="{{ $option['text']['en'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Value</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control optionInput" id="option_value" name="options[{{$key}}][value]" value="{{ $option['value'] ?? '' }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        @endforeach
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="submit" form="elementForm" class="btn btn-sm btn-primary">Save</button>
        </div>
    </div>
</div>

<script>
    $('#copyOptionBtn').on('click', function (e) {
        e.preventDefault();

        if ($('.optionDiv').length > 1) {
            var element = $('.optionDiv').last().clone()

            element.find('input').val('');
            element.attr('data-count', parseInt(element.attr('data-count')) + 1);

            $('.options').append(element);
        }
    })

    function removeOption(el) {
        el.closest('.optionDiv').remove()
    }

    $(document).ready(function () {
        showOptionType('{{ $element['option_type'] ?? '' }}')
    })
    $('#option_type').on('change', function () {
        showOptionType($(this).val())
    });

    function showOptionType(value) {
        $('.optionInput').val('');
        if (value == 'custom') {
            $('#customOption').removeClass('d-none');
        } else if (value == 'model') {
            $('#modelOption').removeClass('d-none');
        } else if (value == 'city') {
            getCountries();
            $('#cityOption').removeClass('d-none');
        } else {
            $('#customOption, #modelOption, #cityOption').addClass('d-none');
        }
    }

    function getCountries() {
        $.ajax({
            url: '{{ route('dawnstar.form_builders.getCountries') }}',
            method: 'GET',
            success: function (response) {
                var content = '<option value="">Seçiniz</option>';
                $.each(response, function (k, v) {
                    content += '<option value="' + k + '"' + ('{{ $element['city_option']['country_id'] ?? '' }}' == k ? " selected" : "") + '>' + v + '</option>';
                })

                $('#city_option').html(content)
            }
        })
    }
</script>
