<ol class="dd-list">
    @foreach($categories as $category)
        <li class="dd-item" data-id="{{ $category->id }}">
            <div class="float-end" style="padding: 0.65rem">
                <i class="mdi mdi-18px mdi-circle text-{{ $category->status == 1 ? 'success' : 'danger' }}"></i>
                <a href="{{ route('dawnstar.structures.categories.edit', [$structure, $category]) }}" class="text-secondary">
                    <i class="mdi mdi-18px mdi-pencil"></i>
                </a>
                <form action="{{ route('dawnstar.structures.categories.destroy', [$structure, $category]) }}" method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn action-icon p-0">
                        <i class="mdi mdi-18px mdi-delete"></i>
                    </button>
                </form>
            </div>
            <div class="dd-handle bg-white py-2 ps-3 rounded-1" style="height: 45px">{{ $category->translation->name }}</div>
            @if($category->children->isNotEmpty())
                @include('Core::modules.category.items', ['categories' => $category->children])
            @endif
        </li>
    @endforeach
</ol>
