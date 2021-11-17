<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\ContainerInterface;
use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;
use Dawnstar\Services\ModuleBuilderService;
use Illuminate\Database\Eloquent\Collection;

class ContainerRepository implements ContainerInterface
{

    public function getById(int $id): Container
    {
        return Container::find($id);
    }

    public function getAll(): Collection
    {
        return Container::all();
    }

    public function getByStatus(int $status): Collection
    {
        return Container::where('status', $status)->get();
    }

    public function store(Structure $structure): Container
    {
        return Container::create(['structure_id' => $structure->id]);
    }

    public function update(Structure $structure, Container $container)
    {
        // TODO: Validation

        $data = request()->except(['_token', '_method', 'translations', 'languages']);

        $container->update($data);
    }

    public function destroy(Container $container)
    {
        // TODO: Implement destroy() method.
    }
}
