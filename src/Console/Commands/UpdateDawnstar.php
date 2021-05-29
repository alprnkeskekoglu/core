<?php

namespace Dawnstar\Console\Commands;

use Dawnstar\Models\Admin;
use Dawnstar\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class UpdateDawnstar extends Command
{
    protected $signature = 'ds:update';
    protected $description = 'Update Dawnstar';

    public function handle()
    {
        if(is_dir(public_path('vendor'))) {
            $this->delTree(public_path('vendor'));
            $this->info(public_path('vendor') . " Deleted !!" . PHP_EOL);
        }

        $this->info('**It may take longer to publish, wait a few seconds.' . PHP_EOL);
        Artisan::call('vendor:publish', ['--all' => true]);
        $this->info(Artisan::output());

        Artisan::call('migrate', ['--force' => true]);
        $this->info(Artisan::output());

        Artisan::call('ds:search');
        $this->info("Search View Updated !!". PHP_EOL);

        Artisan::call('view:clear');
        $this->info("View Cleared !!". PHP_EOL);

        Artisan::call('cache:clear');
        $this->info("Cache Cleared !!". PHP_EOL);

        $this->info("------------------" . PHP_EOL);
        $this->info(" Update Completed " . PHP_EOL);
        $this->info("------------------" . PHP_EOL);
    }


    public function delTree($dir) {
        $files = array_diff(scandir($dir), array('.','..'));
        foreach ($files as $file) {
            if($file == 'storage') continue;
            (is_dir("$dir/$file")) ? $this->delTree("$dir/$file") : unlink("$dir/$file");
        }
    }
}
