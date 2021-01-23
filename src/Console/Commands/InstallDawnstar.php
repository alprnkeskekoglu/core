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

        $this->createDefaultBladeFiles();

        $this->createSymbolicLink();

        Admin::firstOrCreate([
            'role_id' => 1,
            'status' => 1,
            'fullname' => 'Alperen Keşkekoğlu',
            'username' => 'alprnkeskekoglu',
            'email' => 'keskekoglualperen@gmail.com',
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


        $websiteControllerFolder = app_path('Http/Controllers/Website1');
        if (!file_exists($websiteControllerFolder)) {
            $oldmask = umask(0);
            mkdir($websiteControllerFolder, 0777, true);
            umask($oldmask);
        }

        $this->info('Default Website Created !!');
    }

    private function createDefaultBladeFiles()
    {
        $layoutFolder = resource_path('views/layouts');
        $pageFolder = resource_path('views/pages');

        if (!file_exists($layoutFolder)) {
            $oldmask = umask(0);
            mkdir($layoutFolder, 0777, true);
            umask($oldmask);
        }
        if (!file_exists($pageFolder)) {
            $oldmask = umask(0);
            mkdir($pageFolder, 0777, true);
            umask($oldmask);
        }


        $defaultApp = file_get_contents(__DIR__ . '/../../Resources/views/web/default/layouts/app.blade.php');
        file_put_contents(resource_path('views/layouts/app.blade.php'), $defaultApp);

        file_put_contents(resource_path('views/layouts/header.blade.php'), '@include("DawnstarWebView::default.layouts.header")');
        file_put_contents(resource_path('views/layouts/footer.blade.php'), '@include("DawnstarWebView::default.layouts.footer")');

        $this->info('Default Blade Files Created !!');
    }

    private function createSymbolicLink()
    {
        Artisan::call('storage:link');
        $this->info(Artisan::output());
    }
}
