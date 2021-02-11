<?php

namespace Dawnstar\Contracts\Interfaces;

interface ModelStoreInterface
{
    public function store($model, $data);

    public function update($model, $data);

    public function storeDetails($model, $details);

    public function storeExtras($model, $extras);

    public function storeMedias($model, $medias);

    public function storeMetas($model, $metas);
}
