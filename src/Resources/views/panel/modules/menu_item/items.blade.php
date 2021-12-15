<ol class="dd-list">
    @foreach($items as $item)
        <li class="dd-item" data-id="{{ $item->id }}">
            <div class="float-end" style="padding: 0.65rem">
                <i class="mdi mdi-18px mdi-circle text-{{ $item->status == 1 ? 'success' : 'danger' }}"></i>
                <a href="{{ route('dawnstar.menus.items.edit', [$menu, $item]) }}" class="text-secondary">
                    <i class="mdi mdi-18px mdi-pencil"></i>
                </a>
                <form action="{{ route('dawnstar.menus.items.destroy', [$menu, $item]) }}" method="POST" class="d-inline">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn action-icon p-0">
                        <i class="mdi mdi-18px mdi-delete"></i>
                    </button>
                </form>
            </div>
            <div class="dd-handle bg-white py-2 ps-3 rounded-1" style="height: 45px">{{ $item->name }}</div>
            @if($item->children->isNotEmpty())
                @include('Dawnstar::modules.menu_item.items', ['items' => $item->children])
            @endif
        </li>
    @endforeach
</ol>
