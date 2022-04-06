<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\ContainerInterface;
use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

class ContainerRepository implements ContainerInterface
{
    /**
     * @param int $id
     * @return Container
     */
    public function getById(int $id): Container
    {
        return Container::find($id);
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return Container::all();
    }

    /**
     * @param int $status
     * @return Collection
     */
    public function getByStatus(int $status): Collection
    {
        return Container::where('status', $status)->get();
    }

    /**
     * @param Structure $structure
     * @return Container
     */
    public function store(Structure $structure): Container
    {
        return Container::create(['structure_id' => $structure->id]);
    }

    /**
     * @param Container $container
     */
    public function update(Container $container): void
    {
        $data = request()->except(['_token', '_method', 'translations', 'languages', 'medias', 'relations']);

        $container->update($data);

        $this->syncSubPages($container);

        if (request('medias')) {
            $this->getMediaRepository()->syncMedias($container, request('medias'));
        }
    }

    /**
     * @param Container $container
     */
    public function syncSubPages(Container $container): void
    {
        $relations = request('relations');

        if($relations) {
            foreach ($relations as $key => $ids) {
                $container->subPages($key)->syncWithPivotValues($ids, ['key' => $key]);
            }
        } else {
            $container->subPages()->sync([]);
        }
    }

    /**
     * @return MediaRepository
     */
    private function getMediaRepository(): MediaRepository
    {
        return new MediaRepository();
    }
}
