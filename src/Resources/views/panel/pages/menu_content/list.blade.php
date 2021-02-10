<ol class="dd-list">
    @foreach($menuContents as $menuContent)
        <li class="dd-item" data-id="{{ $menuContent->id }}">
            <div class="float-right p-2 mr-2">
                <div class="badge badge-{{ $menuContent->status == 1 ? 'success' : 'danger' }} mr-2">&nbsp;&nbsp;</div>
                <a href="{{ route('dawnstar.menu.content.edit', ['menuId' => $menu->id, 'id' => $menuContent->id]) }}"
                   class="mr-2 {{ isset($selectedMenuContent) && $selectedMenuContent->id == $menuContent->id ? '' : 'text-black' }}"
                   data-toggle="tooltip"
                   data-placement="right"
                   title="{{ __('DawnstarLang::general.edit') }}">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                <a href="javascript:void(0)"
                   data-url="{{ route('dawnstar.menu.content.delete', ['menuId' => $menu->id, 'id' => $menuContent->id]) }}"
                   data-toggle="tooltip"
                   class="text-black deleteBtn"
                   data-placement="right"
                   title="{{ __('DawnstarLang::general.delete') }}">
                    <i class="fa fa-trash-alt"></i>
                </a>
            </div>
            <div class="dd-handle">
                {{ $menuContent->name }}
            </div>
            @if($menuContent->children->isNotEmpty())
                @include('DawnstarView::pages.menu_content.list', ['menuContents' => $menuContent->children])
            @endif
        </li>
    @endforeach
</ol>
