<?php

namespace Dawnstar\Foundation;


use Dawnstar\Models\SearchData;

class Search
{
    public function __construct()
    {
        $dawnstar = dawnstar();
        $this->language = $dawnstar->language;
    }

    public function getResults(int $perPage = 10)
    {
        $request = request();
        $query = strip_tags($request->get('q'));

        $results = $this->search($perPage, $query);

        $newPath = str_replace(["&page=" . $request->get('page'), "page=" . $request->get('page')], "", $request->getRequestUri());
        return $results->withPath(url($newPath));
    }

    private function search(int $perPage, string $query = '')
    {
        return SearchData::where('language_id', $this->language->id)
            ->select('model_id', 'model_type', 'detail_name', 'detail_detail', 'url_id')
            ->where('detail_name', '<>', '')
            ->whereHas('url')
            ->with('url', 'model')
            ->where(function ($q) use ($query) {
                $q->where('detail_name', 'like', '%' . $query . '%')
                    ->orWhere('detail_detail', 'like', '%' . $query . '%')
                    ->orWhere('cvar_1', 'like', '%' . $query . '%')
                    ->orWhere('cvar_2', 'like', '%' . $query . '%')
                    ->orWhere('ctext_1', 'like', '%' . $query . '%')
                    ->orWhere('ctext_2', 'like', '%' . $query . '%')
                    ->orWhere('cint_1', 'like', '%' . $query . '%')
                    ->orWhere('cint_2', 'like', '%' . $query . '%')
                    ->orWhere('detail_value', 'like', '%' . $query . '%')
                    ->orWhere('value', 'like', '%' . $query . '%');
            })
            ->orderByRaw("case
                when `detail_name` like ? then 1
                when `detail_name` like ? then 4
                when `detail_name` like ? then 2
                when `detail_name` like ? then 5
                when `detail_name` like ? then 16
                when `detail_name` like ? then 18
                when `detail_name` like ? then 3
                when `detail_name` like ? then 17

                when `detail_detail` like ? then 6
                when `detail_detail` like ? then 9
                when `detail_detail` like ? then 7
                when `detail_detail` like ? then 10
                when `detail_detail` like ? then 19
                when `detail_detail` like ? then 21
                when `detail_detail` like ? then 8
                when `detail_detail` like ? then 20

                when `detail_value` like ? then 24
                when `detail_value` like ? then 28
                when `detail_value` like ? then 25
                when `detail_value` like ? then 29
                when `detail_value` like ? then 22
                when `detail_value` like ? then 27
                when `detail_value` like ? then 26
                when `detail_value` like ? then 23

                when `value` like ? then 32
                when `value` like ? then 36
                when `value` like ? then 33
                when `value` like ? then 37
                when `value` like ? then 30
                when `value` like ? then 35
                when `value` like ? then 34
                when `value` like ? then 31

                else 1000 end", [
                $query . ' %',              //1
                $query . '%',               //4
                '% ' . $query . ' %',       //2
                '% ' . $query . '%',        //5
                '%' . $query . ' %',        //16
                '%' . $query . '%',         //18
                '% ' . $query . '',         //3
                '%' . $query . '',          //17

                $query . ' %',              //6
                $query . '%',               //9
                '% ' . $query . ' %',       //7
                '% ' . $query . '%',        //10
                '%' . $query . ' %',        //19
                '%' . $query . '%',         //21
                '% ' . $query . '',         //8
                '%' . $query . '',          //20

                $query . ' %',              //11
                $query . '%',               //14
                '% ' . $query . ' %',       //12
                '% ' . $query . '%',        //15
                '%' . $query . ' %',        //22
                '%' . $query . '%',         //14
                '% ' . $query . '',         //13
                '%' . $query . '',          //23

                $query . ' %',              //32
                $query . '%',               //36
                '% ' . $query . ' %',       //33
                '% ' . $query . '%',        //37
                '%' . $query . ' %',        //30
                '%' . $query . '%',         //35
                '% ' . $query . '',         //34
                '%' . $query . '',          //31

            ])
            ->paginate($perPage, ["*"], 'page');
    }
}
