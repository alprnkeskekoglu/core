<div class="modal-header">
    <h5 class="modal-title">Recaptcha</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <form action="{{ route('dawnstar.settings.update') }}" method="post">
        @method('PUT')
        @csrf
        <input type="hidden" name="group_key" value="recaptcha">
        <div class="mb-3 row">
            <label for="recaptcha_site_key" class="col-4 col-form-label">@lang('Core::setting.recaptcha.site_key')</label>
            <div class="col-8">
                <input type="text" class="form-control" id="recaptcha_site_key" name="recaptcha_site_key" value="{{ setting('recaptcha_site_key') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="recaptcha_secret_key" class="col-4 col-form-label">@lang('Core::setting.recaptcha.secret_key')</label>
            <div class="col-8">
                <input type="text" class="form-control" id="recaptcha_secret_key" name="recaptcha_secret_key" value="{{ setting('recaptcha_secret_key') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">@lang('Core::general.save')</button>
    </form>

</div>
