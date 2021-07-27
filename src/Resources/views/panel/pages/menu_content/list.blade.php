<ol class="dd-list">
    @foreach($menuContents as $menuContent)
        <li class="dd-item" data-id="{{ $menuContent->id }}">
            <div class="float-right mr-2 my-1 d-inline-flex">
                <div class="badge badge-{{ $menuContent->status == 1 ? 'success' : 'danger' }} mt-2 mr-2" style="height: 14px; padding: 4px">&nbsp;&nbsp;</div>
                <a href="{{ route('dawnstar.menus.contents.edit', [$menu, $menuContent]) }}"
                   class="mr-2 text-black btn btn-sm {{ isset($selectedMenuContent) && $selectedMenuContent->id == $menuContent->id ? 'btn-info' : 'btn-outline-info' }}"
                   data-toggle="tooltip"
                   data-placement="right"
                   title="{{ __('DawnstarLang::general.edit') }}">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                @if(!isset($selectedMenuContent) || (isset($selectedMenuContent) && $selectedMenuContent->id != $menuContent->id))
                    <form action="{{ route('dawnstar.menus.contents.destroy', [$menu, $menuContent]) }}" method="post">
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="child_delete" value="2">
                        <button type="button"
                                data-toggle="tooltip"
                                class="text-black mr-2 btn btn-sm btn-outline-danger deleteBtn"
                                data-placement="right"
                                title="{{ __('DawnstarLang::general.delete') }}">
                            <i class="fa fa-trash-alt"></i>
                        </button>
                    </form>
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
