<?php

namespace Dawnstar\Contracts;

interface MediaInterface
{
    public function syncMedias($model, array $medias = []): void;
}
