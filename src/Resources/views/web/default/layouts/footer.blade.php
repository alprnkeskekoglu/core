<!-- Footer -->
<footer class="page-footer font-small stylish-color-dark pt-4">

    <hr>
    <!-- Footer Links -->
    <div class="container text-center text-md-left">

        <div class="row">
            <div class="col-md-4 mx-auto">
                <h5 class="font-weight-bold text-uppercase mt-3 mb-4">{!! langPart('footer.title', "Footer Content") !!}</h5>
                <p>{!! langPart('footer.content', "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur pulvinar metus sodales nulla
                    sollicitudin, id commodo purus fringilla.") !!}</p>

                <ul class="list-unstyled list-inline">
                    @foreach(socialMedia() as $media)
                        <li class="list-inline-item">
                            <a href="{!! $media['link'] !!}" target="_blank" rel="nofollow">
                                <i class="fab fa-{!! $media['name'] !!}"></i>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-8">
                <div class="row">
                    <div class="col-md-6 offset-6">
                        <div class="ebulletin-message"></div>
                        <form method="POST" class="ebulletin-form input-group">
                            @csrf
                            <input type="email"
                                   class="form-control form-control-sm"
                                   name="email" id="mail"
                                   required
                                   placeholder="{!! strip_tags(langPart("footer.ebulletin_input", "E-Posta adresinizi giriniz.")) !!}">
                            <div class="input-group-append float-right">
                                <button class="btn btn-primary btn-sm" id="ebulletin-btn"><span>{!! langPart("footer.ebulletin_button", "Gönder") !!} </span></button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    @foreach($mediapress->menu('footer-menu') as $menu)
                        <hr class="clearfix w-100 d-md-none">
                        <div class="col-md-2 mx-auto">
                            <h5 class="font-weight-bold text-uppercase mt-3 mb-4">
                                <a href="{!! $menu->url !!}">{!! $menu->name !!}</a>
                            </h5>
                            @if($menu->children->isNotEmpty())
                                <ul class="list-unstyled">
                                    @foreach($menu->children as $child)
                                        <li>
                                            <a href="{!! $child->url !!}">{!! $child->name !!}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright text-center py-3">© {!! langPart('footer.copyright', "2020 Copyright:") !!}
        <a href="https://mediaclick.com.tr" target="_blank">Powered by MediapressCMS</a>
    </div>
</footer>

@push("scripts")
    <script>
        $("#ebulletin-btn").click(function (event) {
            event.preventDefault();
            var url = "{!! route('ebulletin.sender') !!}";
            var data = $('.ebulletin-form').serialize();
            $.post(url, data)
                .done(function(response) {
                    console.log(response);
                    $('.ebulletin-message').html('');
                    $('.ebulletin-message').append(' <div class="alert alert-success"><ul><li>' + response.response + '</li></ul></div>');
                })
                .fail(function(response) {
                    console.log(response);
                    $('.ebulletin-message').html('');
                    if(response.status == 422) {
                        $('.ebulletin-message').append(' <div class="alert alert-danger"><ul><li>' + response.responseJSON.errors.email[0] + '</li></ul></div>');
                    } else {
                        $('.ebulletin-message').append(' <div class="alert alert-danger"><ul><li>' + response.statusText + '</li></ul></div>');
                    }

                });
        });
    </script>

@endpush
