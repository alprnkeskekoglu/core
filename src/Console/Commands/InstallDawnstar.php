<?php

namespace Dawnstar\Console\Commands;

use Dawnstar\Models\Admin;
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

        Admin::create([
            'role_id' => 1,
            'fullname' => 'test',
            'username' => 'test',
            'email' => 'test@test.com',
            'password' => '$2y$10$c0ncNq4BfdWo4gINdcdnEu9rc7BxBHjK9LhE.6sIDIawcjAYlt6VS'
        ]);
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
