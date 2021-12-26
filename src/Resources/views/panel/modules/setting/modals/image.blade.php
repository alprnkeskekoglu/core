<div class="modal-header">
    <h5 class="modal-title">Image</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('dawnstar.settings.update') }}" method="post">
        @method('PUT')
        @csrf
        <input type="hidden" name="group_key" value="image">

        <div class="mb-3 row">
            <label class="col-4 col-form-label">@lang('Core::setting.image.webp_status')</label>
            <div class="col-8 mt-1">
                <div class="form-check form-check-inline">
                    <input type="radio" id="webp_status_1" name="webp_status"
                           class="form-check-input" value="1" {{ setting('webp_status') == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="webp_status_1">@lang('Core::general.status_options.1')</label>
                </div>
                <div class="form-check form-check-inline">
                    <input type="radio" id="webp_status_0" name="webp_status"
                           class="form-check-input" value="0" {{ setting('webp_status', 0) == 0 ? 'checked' : '' }}>
                    <label class="form-check-label" for="webp_status_0">@lang('Core::general.status_options.0')</label>
                </div>
            </div>
        </div>


        <div class="mb-3 row">
            <div class="col-4">
                <label for="quality" class="col-form-label">
                    @lang('Core::setting.image.quality')
                </label>
                <div class="mt-1">
                    <ul>
                        <li>
                            <span>
                                @lang('Core::setting.image.quality')
                                <small id="image-quality">{{ setting('quality', 90) }}</small>
                            </span>
                        </li>
                        <li>
                            <span>
                                @lang('Core::setting.image.size')
                                <small>{{ unitSizeForHuman(filesize(public_path('vendor/dawnstar/core/medias/sample.jpg'))) }}</small>
                            </span>
                        </li>
                        <li>
                            <span>
                                @lang('Core::setting.image.new_size')
                                <small id="image-size">{{ unitSizeForHuman(filesize(public_path('vendor/dawnstar/core/medias/sample.jpg'))) }}</small>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-8 mt-1">
                <input class="form-range" id="quality" type="range" name="quality" min="1" max="100"
                       value="{{ setting('quality', 90) }}"
                       onchange="updateImage(this.value)">

                <div class="mt-1">
                    <img src="{{ asset('vendor/dawnstar/core/medias/sample.jpg') }}" class="img-fluid" id="image">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">@lang('Core::general.save')</button>
    </form>
</div>
