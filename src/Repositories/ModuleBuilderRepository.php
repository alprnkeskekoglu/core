<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\ModuleBuilderInterface;
use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

class ModuleBuilderRepository implements ModuleBuilderInterface
{

    public function getAll(): Collection
    {
        return ModuleBuilder::all();
    }

    public function store(Structure $structure): void
    {
        $types = [];

        if ($structure->has_detail) {
            $types[] = 'container';
        }

        if ($structure->type == 'dynamic') {
            $types[] = 'page';

            if ($structure->has_category) {
                $types[] = 'category';

                if ($structure->has_property) {
                    $types[] = 'property';
                }
            }
        }

        foreach ($types as $type) {

            $data = include __DIR__ . '/../Resources/module_builder/' . $type . '.php';

            ModuleBuilder::firstOrCreate(
                [
                    'structure_id' => $structure->id,
                    'type' => $type,
                    'data' => $data,
                    'meta_tags' => ['title', 'description']
                ]
            );
        }
    }
}
