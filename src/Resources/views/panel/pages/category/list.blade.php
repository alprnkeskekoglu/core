<ol class="dd-list">
    @foreach($categories as $category)
        <li class="dd-item" data-id="{{ $category->id }}">
            <div class="float-right mr-2 my-1 d-inline-flex">
                <div class="badge badge-{{ getStatusColorClass($category->status) }} mt-2 mr-2" style="height: 14px; padding: 4px">&nbsp;&nbsp;</div>
                <a href="{{ route('dawnstar.containers.categories.edit', [$container, $category]) }}" class="mr-2 btn btn-sm btn-outline-info text-black"
                   data-toggle="tooltip" data-placement="right" title="{{ __('DawnstarLang::general.edit') }}">
                    <i class="fa fa-pencil-alt"></i>
                </a>

                <form action="{{ route('dawnstar.containers.categories.destroy', [$container, $category]) }}" method="post">
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
            </div>
            <div class="dd-handle" style="height: 2.5rem">{{ $category->detail->name }}</div>
            @if($category->children->isNotEmpty())
                @include('DawnstarView::pages.category.list', ['categories' => $category->children])
            @endif
        </li>
    @endforeach
</ol>
