<?php

namespace Dawnstar\Core\Contracts;

interface MediaInterface
{
    public function syncMedias($model, array $medias = []): void;
}
