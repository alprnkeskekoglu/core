<?php

namespace Dawnstar\Contracts;

use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;
use Illuminate\Database\Eloquent\Collection;

interface ModuleBuilderInterface
{
    public function getAll(): Collection;

    public function store(Structure $structure): void;

    public function createFiles(Structure $structure): void;
}
