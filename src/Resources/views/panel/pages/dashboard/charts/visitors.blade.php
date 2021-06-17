<div class="col-md-12 mt-4">
    <div class="row">
        <div class="col-md-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div><i class="fa fa-2x fa-user-circle text-success"></i></div>
                    <div class="ml-3 text-right">
                        <p class="font-size-h3 font-w300 mb-0" id="onlineCount">0</p>
                        <p class="text-muted mb-0">Aktif Kullanıcı</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div><i class="fa fa-2x fa-user-circle text-primary"></i></div>
                    <div class="ml-3 text-right">
                        <p class="font-size-h3 font-w300 mb-0">{{ $visitors['daily'] }}</p>
                        <p class="text-muted mb-0">Günlük Kullanıcı</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div><i class="fa fa-2x fa-user-circle text-warning"></i></div>
                    <div class="ml-3 text-right">
                        <p class="font-size-h3 font-w300 mb-0">{{ $visitors['weekly'] }}</p>
                        <p class="text-muted mb-0">Haftalık Kullanıcı</p>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-3">
            <a class="block block-rounded block-link-pop" href="javascript:void(0)">
                <div class="block-content block-content-full d-flex align-items-center justify-content-between">
                    <div><i class="fa fa-2x fa-user-circle text-danger"></i></div>
                    <div class="ml-3 text-right">
                        <p class="font-size-h3 font-w300 mb-0">{{ $visitors['monthly'] }}</p>
                        <p class="text-muted mb-0">Aylık Kullanıcı</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

@push('after_scripts')
    <script>
        getOnlineCount();

        function getOnlineCount() {
            $.ajax({
                url: '{{ route('dawnstar.dashboard.getOnlineCount') }}',
                success: function (response) {
                    $('#onlineCount').html(response);
                    setTimeout(getOnlineCount, 3000);
                }
            })
        }
    </script>
@endpush
