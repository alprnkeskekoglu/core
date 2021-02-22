<ol class="dd-list">
    @foreach($categories as $category)
        <li class="dd-item" data-id="{{ $category->id }}">
            <div class="float-right mr-2 my-1">
                <div class="badge badge-{{ getStatusColorClass($category->status) }} mr-2">&nbsp;&nbsp;</div>
                <a href="{{ route('dawnstar.containers.categories.edit', ['containerId' => $container->id, 'id' => $category->id]) }}" class="mr-2 btn btn-sm btn-outline-info text-black"
                   data-toggle="tooltip" data-placement="right" title="{{ __('DawnstarLang::general.edit') }}">
                    <i class="fa fa-pencil-alt"></i>
                </a>
                <a href="javascript:void(0);"
                   class="text-black mr-2 btn btn-sm btn-outline-danger deleteBtn"
                   data-url="{{ route('dawnstar.containers.categories.destroy', ['containerId' => $container->id, 'id' => $category->id]) }}"
                   data-toggle="tooltip"
                   data-placement="right"
                   title="{{ __('DawnstarLang::general.delete') }}">
                    <i class="fa fa-trash-alt"></i>
                </a>
            </div>
            <div class="dd-handle" style="height: 2.5rem">{{ $category->detail->name }}</div>
            @if($category->children->isNotEmpty())
                @include('DawnstarView::pages.category.list', ['categories' => $category->children])
            @endif
        </li>
    @endforeach
</ol>
