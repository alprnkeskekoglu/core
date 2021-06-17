<div class="col-md-12 mt-4">
    <div class="block block-rounded block-mode-loading-refresh">
        <div class="block-header block-header-default text-center">
            <h3 class="block-title">En çok Ziyaret Edilen Sayfalar</h3>
        </div>
        <div class="block-content">
            <table class="table table-striped table-hover table-borderless table-vcenter font-size-sm">
                <thead>
                <tr class="text-uppercase">
                    <th class="font-w700">Sayfa Adı</th>
                    <th class="font-w700">Sayfa Url</th>
                    <th class="font-w700 text-center" style="width: 120px;">Sayı</th>
                </tr>
                </thead>
                <tbody>
                @foreach($mostVisitedPages as $page)
                    <tr>
                        <td><span class="font-w600">{!! $page['name'] !!}</span></td>
                        <td><span>{!! $page['url'] !!}</span></td>
                        <td class="text-center">{!! $page['count'] !!}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
