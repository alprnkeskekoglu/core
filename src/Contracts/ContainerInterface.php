<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Container;
use Dawnstar\Core\Models\Structure;

interface ContainerInterface extends BaseInterface
{
    public function store(Structure $structure): Container;

    public function update(Container $container);

    public function syncCustomPages(Container $container);
}
