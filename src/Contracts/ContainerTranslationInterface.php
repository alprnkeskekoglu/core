<?php

namespace Dawnstar\Contracts;


use Illuminate\Foundation\Http\FormRequest;
use Dawnstar\Models\Container;

interface ContainerTranslationInterface
{
    public function getById(int $id);

    public function store(Container $container, FormRequest $containerTranslationRequest);

    public function update(Container $container, FormRequest $containerTranslationRequest);

    public function destroy(Container $container);
}
