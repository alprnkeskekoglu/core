<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ ucwords($element['type']) }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div>
        <div class="modal-body pb-1">
            <form action="">
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
                <h2 class="content-heading">Input</h2>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="attr_class">Class</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="attr_class" name="input[attributes][class]" value="{{ $element['input']['attributes']['class'] ?? 'form-control' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="attr_id">Id</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="attr_id" name="input[attributes][id]" value="{{ $element['input']['attributes']['id'] ?? '' }}">
                    </div>
                </div>
                <h2 class="content-heading">Other</h2>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="max_media_count">Max Media</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="max_media_count" name="max_media_count" value="{{ $element['max_media_count'] ?? 'form-control' }}">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label" for="media_type">Media Type</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="media_type" name="media_type">
                            <option value="image" {{ $element['media_type'] ??= 'image' ? 'selected' : '' }}>Image</option>
                            <option value="file" {{ $element['media_type'] ??= 'file' ? 'selected' : '' }}>File</option>
                            <option value="audio" {{ $element['media_type'] ??= 'audio' ? 'selected' : '' }}>Audio</option>
                            <option value="video" {{ $element['media_type'] ??= 'video' ? 'selected' : '' }}>Video</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-sm btn-primary" data-dismiss="modal">Save</button>
        </div>
    </div>
</div>
