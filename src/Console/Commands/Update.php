<?php

namespace Dawnstar\Core\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Dawnstar\Core\Database\seeds\LanguageSeeder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class Update extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ds:update
                            {--f|fresh : Fresh Migrate}
                            {--s|seed  : Database Seed}';

    protected $description = 'Update Dawnstar';

    public function handle()
    {
        File::deleteDirectory(public_path('vendor/dawnstar'));
        File::deleteDirectory(public_path('vendor/media-manager'));
        $this->info(public_path('vendor') . " Deleted !!" . PHP_EOL);
        $this->info('**It may take longer to publish, wait a few seconds.' . PHP_EOL);
        Artisan::call('vendor:publish', ['--tag' => ['dawnstar-assets', 'media-manager-assets']]);
        $this->info(Artisan::output());

        if($this->option('fresh')) {
            Artisan::call('migrate:fresh', ['--force' => true]);
            $this->info(Artisan::output());
        } else {
            Artisan::call('migrate', ['--force' => true]);
            $this->info(Artisan::output());
        }

        if($this->option('seed')) {
            $seeder = new DatabaseSeeder();
            $seeder->call([
                LanguageSeeder::class
            ]);
            $this->info("Database seed completed!" . PHP_EOL);
        }

        Artisan::call('optimize:clear');
        $this->info(Artisan::output());

        $this->info("------------------" . PHP_EOL);
        $this->info(" Update Completed " . PHP_EOL);
        $this->info("------------------" . PHP_EOL);
    }
}
