<?php

namespace Dawnstar\Core\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $files = $this->app['files']->files(__DIR__ . '/../Config');
        foreach ($files as $file) {
            $filename = $this->getConfigBasename($file);
            $this->mergeConfig($file, $filename);
        }
    }

    protected function getConfigBasename($file)
    {
        return preg_replace('/\\.[^.\\s]{3,4}$/', '', basename($file));
    }

    protected function mergeConfig($path, $key)
    {
        $config = config($key);

        foreach (require $path as $k => $v) {
            if (is_array($v)) {
                if (isset($config[$k])) {
                    $config[$k] = array_merge($config[$k], $v);
                } else {
                    $config[$k] = $v;
                }

            } else {
                $config[$k] = $v;
            }
        }
        config([$key => $config]);
    }
}
