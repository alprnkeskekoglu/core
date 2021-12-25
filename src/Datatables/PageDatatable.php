<?php

namespace Dawnstar\Core\Datatables;

use Dawnstar\Core\Models\Page;
use Dawnstar\Core\Models\Structure;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class PageDatatable
{
    public function query(Structure $structure, Request $request)
    {
        $order = $this->getOrder($request);

        $pages = Page::where('structure_id', $structure->id)->with('translation');

        if ($order) {
            $pages = $pages->orderBy($order[0], $order[1]);
        }

        $pages = $pages->skip($request->get('start'))->take($request->get('length'));

        return DataTables::of($pages)
            ->editColumn('status', function ($page) {
                return '<span class="badge bg-' . statusClass($page->status) . ' font-16">' . statusText($page->status) . '</span>';
            })
            ->editColumn('name', function ($page) {
                return optional($page->translation)->name;
            })
            ->editColumn('created_at', function ($page) {
                return $page->created_at;
            })
            ->editColumn('updated_at', function ($page) {
                return $page->updated_at;
            })
            ->addColumn('actions', function ($page) use ($structure) {
                return '' .
                    '<a href="' . route('dawnstar.structures.pages.edit', [$structure, $page]) . '" class="action-icon"><i class="mdi mdi-pencil"></i></a>' .
                    '<form action="' . route('dawnstar.structures.pages.destroy', [$structure, $page]) . '" method="POST" class="d-inline">' .
                    '<input type="hidden" name="_method" value="DELETE">' .
                    csrf_field() .
                    '<button type="submit" class="btn action-icon"><i class="mdi mdi-delete"></i></button>' .
                    '</form>';
            })
            ->rawColumns(['status', 'actions'])
            ->make(true);
    }

    private function getOrder(Request $request)
    {
        $order = $request->get('order')[0];
        $column = $request->get('columns')[$order['column']] ?? null;

        if (is_null($column)) {
            return null;
        }

        return [$column['name'], $order['dir']];
    }
}
