<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Meta Tags</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body pb-1">
            <form action="{{ route('dawnstar.form_builders.saveElement') }}" id="elementForm" method="POST">
                @csrf
                <input type="hidden" name="formBuilder" value="{{ $formBuilder->id }}">
                <input type="hidden" name="key" value="{{ $key }}">
                <h2 class="content-heading">Options <button class="btn bg-black-10" id="copyOptionBtn"><i class="fa fa-plus"></i></button></h2>
                <div class="options">
                    @foreach($element as $key)
                        <div class="optionDiv" data-count="{{ $loop->iteration }}">
                            <button class="btn btn-sm btn-danger" onclick="removeOption(this)"><i class="fa fa-trash"></i></button>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" id="meta_{{$key['type']}}" name="metas[{{$loop->iteration}}][type]" value="{{ $key['type'] }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                        </div>
                    @endforeach
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
        if($('.optionDiv').length > 0) {
            var element = $('.optionDiv').last().clone()
            var key = parseInt(element.attr('data-count'));

            element.find('input').val('');
            element.attr('data-count', key + 1);

            element.find('input').map(function (k, el) {
                el.setAttribute('name', el.getAttribute('name').replace('[' + key + ']', '[' + (key + 1) + ']'))
            });

            $('.options').append(element);
        }
    })

    function removeOption(el) {
        el.closest('.optionDiv').remove()
    }
</script>
