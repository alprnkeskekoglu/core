<ol class="dd-list">
    @foreach($menuContents as $menuContent)
        <li class="dd-item" data-id="{{ $menuContent->id }}">
            <div class="float-right mr-2 my-1">
                <div class="badge badge-{{ $menuContent->status == 1 ? 'success' : 'danger' }} mr-2">&nbsp;&nbsp;</div>
                <a href="{{ route('dawnstar.menus.contents.edit', ['menuId' => $menu->id, 'id' => $menuContent->id]) }}"
                   class="mr-2 text-black btn btn-sm {{ isset($selectedMenuContent) && $selectedMenuContent->id == $menuContent->id ? 'btn-info' : 'btn-outline-info' }}"
                   data-toggle="tooltip"
                   data-placement="right"
                   title="{{ __('DawnstarLang::general.edit') }}">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                @if(!isset($selectedMenuContent) || (isset($selectedMenuContent) && $selectedMenuContent->id != $menuContent->id))
                    <a href="javascript:void(0)"
                       data-url="{{ route('dawnstar.menus.contents.destroy', ['menuId' => $menu->id, 'id' => $menuContent->id]) }}"
                       data-toggle="tooltip"
                       class="text-black mr-2 btn btn-sm btn-outline-danger deleteBtn"
                       data-placement="right"
                       title="{{ __('DawnstarLang::general.delete') }}">
                        <i class="fa fa-trash-alt"></i>
                    </a>
                @endif
            </div>
            <div class="dd-handle" style="height: 2.5rem">
                {{ $menuContent->name }}
            </div>
            @if($menuContent->children->isNotEmpty())
                @include('DawnstarView::pages.menu_content.list', ['menuContents' => $menuContent->children])
            @endif
        </li>
    @endforeach
</ol>
