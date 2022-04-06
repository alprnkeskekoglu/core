<?php

namespace Dawnstar\Core\Services;

use Dawnstar\Core\Models\Website;
use Dawnstar\Core\Models\Structure;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class ModuleFileService
{
    protected Website $website;

    public function __construct(protected Structure $structure)
    {
        $this->website = $structure->website;
    }

    public function createController()
    {
        $folder = app_path('Http/Controllers/Website' . $this->website->id);
        if (!file_exists($folder)) {
            $oldmask = umask(0);
            mkdir($folder, 0777, true);
            umask($oldmask);
        }

        $content = $this->getControllerContent();

        Artisan::call('make:controller Website' . $this->website->id . '/' . ucfirst($this->structure->key) . 'Controller');

        file_put_contents($folder . '/' . ucfirst($this->structure->key) . 'Controller.php', $content);
    }

    public function createBlades()
    {
        $folder = resource_path('views/modules/' . strtolower($this->structure->key));
        if (!is_dir($folder)) {
            File::makeDirectory($folder, 0777, true, true);
        }

        if (in_array($this->structure->type, ['static', 'search'])) {
            $this->createBlade('container');
        } else {
            if ($this->structure->has_detail) {
                $this->createBlade('container');
            }

            $this->createBlade('page');

            if ($this->structure->has_category) {
                $this->createBlade('category');
            }
        }
    }

    #region Controller
    private function getControllerContent()
    {
        $defaultContent = file_get_contents(base_path('vendor/dawnstar/core/src/Resources/stubs/Controller.stub'));

        $replaceKeys = [
            '{&namespace&}', '{&class&}', '{%container%}', '{%page%}', '{%category%}'
        ];

        $replaceValues = [
            "App\Http\Controllers\Website{$this->website->id}",
            ucfirst($this->structure->key) . "Controller",
        ];

        $replaceValues[] = $this->getControllerFunction('container');
        if ($this->structure->type == 'dynamic') {
            $replaceValues[] = $this->getControllerFunction('page');
            if ($this->structure->has_category) {
                $replaceValues[] = $this->getControllerFunction('category');
            } else {
                $replaceValues[] = '';
            }
        } else {
            $replaceValues[] = '';
            $replaceValues[] = '';
        }

        return str_replace($replaceKeys, $replaceValues, $defaultContent);
    }

    private function getControllerFunction(string $type)
    {
        $content = "public function {$type}(Dawnstar \$dawnstar) {";

        if($this->structure->key == 'search') {
            $content .= "\n\t\t" . '$search = new \Dawnstar\Foundation\Search();';
            $content .= "\n\t\t" . '$results = $search->getResults();';
            $content .= "\n\t\treturn view('modules." . strtolower($this->structure->key) . ".{$type}', compact('results'));";
        } else {
            $content .= "\n\t\treturn view('modules." . strtolower($this->structure->key) . ".{$type}');";
        }

        $content .= "\n\t}\n";

        return $content;
    }
    #endregion

    #region Blade
    private function createBlade(string $type)
    {
        $folder = resource_path('views/modules/' . strtolower($this->structure->key));
        $view = $folder . "/{$type}.blade.php";

        if (!file_exists($view)) {
            $replaced = "@extends('layouts.app')\n\n@section('content')\n\t\n@endsection";
            file_put_contents($view, $replaced);
        }
    }
    #endregion
}
