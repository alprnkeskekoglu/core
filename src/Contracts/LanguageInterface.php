<?php

namespace Dawnstar\Core\Contracts;

use Dawnstar\Core\Models\Language;
use Illuminate\Database\Eloquent\Collection;

interface LanguageInterface extends BaseInterface
{
    public function getById(int $id): Language;

    public function getByCode(string $code): Language;

    public function getAll(): Collection;
}
