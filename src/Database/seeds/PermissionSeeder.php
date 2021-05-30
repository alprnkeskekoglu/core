<?php

namespace Dawnstar\Database\seeds;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{

    public function run()
    {
        Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);


        Permission::insert([
            ['name' => 'website.1.*', 'guard_name' => 'admin'],

            ['name' => 'website.1.container_structure.index', 'guard_name' => 'admin'],
            ['name' => 'website.1.container_structure.edit', 'guard_name' => 'admin'],
            ['name' => 'website.1.container_structure.destroy', 'guard_name' => 'admin'],

            ['name' => 'website.1.admin.index', 'guard_name' => 'admin'],
            ['name' => 'website.1.admin.create', 'guard_name' => 'admin'],
            ['name' => 'website.1.admin.edit', 'guard_name' => 'admin'],
            ['name' => 'website.1.admin.destroy', 'guard_name' => 'admin'],

            ['name' => 'website.1.menu.index', 'guard_name' => 'admin'],
            ['name' => 'website.1.menu.create', 'guard_name' => 'admin'],
            ['name' => 'website.1.menu.edit', 'guard_name' => 'admin'],
            ['name' => 'website.1.menu.destroy', 'guard_name' => 'admin'],

            ['name' => 'website.1.form.index', 'guard_name' => 'admin'],
            ['name' => 'website.1.form.create', 'guard_name' => 'admin'],
            ['name' => 'website.1.form.edit', 'guard_name' => 'admin'],
            ['name' => 'website.1.form.destroy', 'guard_name' => 'admin'],
            ['name' => 'website.1.form.results', 'guard_name' => 'admin'],

            ['name' => 'website.1.custom_content.index', 'guard_name' => 'admin'],
            ['name' => 'website.1.custom_content.edit', 'guard_name' => 'admin'],
            ['name' => 'website.1.custom_content.destroy', 'guard_name' => 'admin'],

            ['name' => 'website.1.file_manager.index', 'guard_name' => 'admin'],

        ]);
    }
}
