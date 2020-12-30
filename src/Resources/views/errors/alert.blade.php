@if($errors->any())
<div class="alert alert-danger alert-dismissable" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">×</span>
    </button>

    <h3 class="alert-heading font-size-h4 mb-3 mt-1">
        <i class="fa fa-fw fa-times-circle"></i>
        {{ __('DawnstarLang::general.error_occured') }}
    </h3>
    <ul>
        @foreach($errors->all() as $error)
            <li>
                {!! $error !!}
            </li>
        @endforeach
    </ul>
</div>
@endif
