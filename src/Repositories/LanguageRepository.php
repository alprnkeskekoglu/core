<?php

namespace Dawnstar\Core\Repositories;

use Dawnstar\Core\Contracts\LanguageInterface;
use Dawnstar\Core\Models\Language;
use Illuminate\Database\Eloquent\Collection;

class LanguageRepository implements LanguageInterface
{

    public function getById(int $id): Language
    {
        return Language::find($id);
    }

    public function getByCode(string $code): Language
    {
        return Language::where('code', $code)->first();
    }

    public function getAll(): Collection
    {
        return Language::all();
    }
}
