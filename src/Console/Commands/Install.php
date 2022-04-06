<?php

namespace Dawnstar\Core\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Dawnstar\Core\Database\seeds\LanguageSeeder;
use Dawnstar\Core\Database\seeds\AdminSeeder;
use Dawnstar\Core\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Role;

class Install extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ds:install';

    protected $description = 'Install Dawnstar';

    public function handle()
    {
        if(! $this->confirm('Are you sure?')) {
            return;
        }

        $this->removeUserMigration();

        $this->vendorPublish();
        $this->migrate();
        $this->seed();

        $this->cleanWebRoute();
        $this->createDirectories();
        $this->createSymbolicLink();

        @unlink(resource_path('views/welcome.blade.php'));

        Artisan::call('optimize:clear');
        $this->info(Artisan::output());

        $this->info("------------------" . PHP_EOL);
        $this->info(" Install Completed " . PHP_EOL);
        $this->info("------------------" . PHP_EOL);
    }

    private function removeUserMigration()
    {
        @unlink(base_path('database/migrations/2014_10_12_000000_create_users_table.php'));
    }

    private function vendorPublish()
    {
        File::deleteDirectory(public_path('vendor'));

        $this->info(public_path('vendor') . " Deleted !!" . PHP_EOL);
        $this->info('**It may take longer to publish, wait a few seconds.' . PHP_EOL);
        Artisan::call('vendor:publish', ['--all' => true]);
        $this->info(Artisan::output());
    }

    private function migrate()
    {
        Artisan::call('migrate', ['--force' => true]);
        $this->info(Artisan::output());
    }

    private function seed()
    {
        $seeder = new DatabaseSeeder();
        $seeder->call([
            LanguageSeeder::class,
            AdminSeeder::class
        ]);
        $this->info("Database seed completed!" . PHP_EOL);
    }

    private function cleanWebRoute()
    {
        $file = base_path('routes/web.php');

        $content = file_get_contents($file);

        if (strpos($content, 'view(\'welcome\');') !== false) {
            file_put_contents($file, '<?php');
            $this->info("Web route file has been cleaned");
        } else {
            $this->info("Web route file was changed already");
        }
    }

    private function createDirectories()
    {
        $oldmask = umask(0);
        if (!is_dir(resource_path('views/layouts'))) {
            File::makeDirectory(resource_path('views/layouts'), 0777, true, true);

            $appLayout = file_get_contents(base_path('vendor/dawnstar/core/src/Resources/stubs/app.stub'));
            file_put_contents(resource_path('views/layouts/app.blade.php'), $appLayout);
        }
        if (!is_dir(resource_path('views/includes'))) {
            File::makeDirectory(resource_path('views/includes'), 0777, true, true);
        }

        umask($oldmask);

        $this->info('Directories created!');
    }

    private function createSymbolicLink()
    {
        Artisan::call('storage:link');
        $this->info(Artisan::output());
    }
}
