<?php

namespace Dawnstar\Console\Commands;

use Dawnstar\Models\Website;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class InstallDawnstar extends Command
{
    protected $signature = 'dawnstar';
    protected $description = 'Installation of Dawnstar CMS';

    public function handle()
    {
        $this->createDefaultWebsite();
    }

    private function createDefaultWebsite()
    {
        $parsedUrl = parse_url(config('app.url'));
        $parsedUrl = isset($parsedUrl["host"]) ? $parsedUrl["host"] : $parsedUrl["path"];

        Website::firstOrCreate([
            'status' => 1,
            'order' => 1,
            'is_default' => 1,
            'name' => config('app.name'),
            'slug' => $parsedUrl,
        ]);

        $this->info('Default Website Created !!');
    }
}
