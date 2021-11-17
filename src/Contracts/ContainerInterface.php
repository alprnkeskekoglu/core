<?php

namespace Dawnstar\Contracts;


use Dawnstar\Http\Requests\ContainerRequest;
use Dawnstar\Models\Container;
use Dawnstar\Models\ModuleBuilder;
use Dawnstar\Models\Structure;

interface ContainerInterface extends BaseInterface
{
    public function store(Structure $structure): Container;

    public function update(Structure $structure, Container $container);

    public function destroy(Container $container);
}
