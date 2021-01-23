<?php

namespace Dawnstar\Observers;

use Dawnstar\Models\Container;
use Dawnstar\Models\Url;

class ContainerObserver
{
    public function deleted(Container $container)
    {
        foreach ($container->details as $detail) {
            $detail->delete();
        }

    }
}
