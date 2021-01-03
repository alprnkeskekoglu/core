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

@if(session('success_message'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <div class="flex-00-auto">
            <i class="fa fa-fw fa-check"></i>
        </div>
        <div class="flex-fill ml-3">
            <p class="mb-0">{!! session('success_message') !!}</p>
        </div>
    </div>
@endif
