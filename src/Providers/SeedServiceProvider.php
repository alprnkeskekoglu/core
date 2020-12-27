<?php

namespace Dawnstar\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Console\Events\CommandFinished;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\ServiceProvider;

class SeedServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->runSeeds();
    }
    private function runSeeds()
    {
        if ($this->app->runningInConsole()) {
            if ($this->isConsoleCommandContains(['db:seed', '--seed'])) {
                Event::listen(CommandFinished::class, function (CommandFinished $event) {
                    if ($event->output instanceof ConsoleOutput) {

                        $file_names = glob(__DIR__ . '/../Database/seeds/*.php');
                        foreach ($file_names as $filename) {
                            $classes = $this->getClassesFromFile($filename);
                            foreach ($classes as $class) {
                                Artisan::call('db:seed', ['--class' => $class, '--force' => '']);
                            }
                        }
                    }
                });
            }
        }
    }
    private function isConsoleCommandContains($contain_options, $exclude_options = null): bool
    {
        $args = request()->server('argv', null);
        if (is_array($args)) {
            $command = implode(' ', $args);
            if (\Str::contains($command, $contain_options) && ($exclude_options == null || !\Str::contains($command, $exclude_options))) {
                return true;
            }
        }
        return false;
    }
    private function getClassesFromFile(string $filename) : array
    {
        // Get namespace of class (if vary)
        $namespace = "";
        $lines = file($filename);
        $namespaceLines = preg_grep('/^namespace /', $lines);
        if (is_array($namespaceLines)) {
            $namespaceLine = array_shift($namespaceLines);
            $match = array();
            preg_match('/^namespace (.*);$/', $namespaceLine, $match);
            $namespace = array_pop($match);
        }

        // Get name of all class has in the file.
        $classes = array();
        $php_code = file_get_contents($filename);
        $tokens = token_get_all($php_code);
        $count = count($tokens);
        for ($i = 2; $i < $count; $i++) {
            if ($tokens[$i - 2][0] == T_CLASS && $tokens[$i - 1][0] == T_WHITESPACE && $tokens[$i][0] == T_STRING) {
                $class_name = $tokens[$i][1];
                if ($namespace !== "") {
                    $classes[] = $namespace . "\\$class_name";
                } else {
                    $classes[] = $class_name;
                }
            }
        }

        return $classes;
    }
}
