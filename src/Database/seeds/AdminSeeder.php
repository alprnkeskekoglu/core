<?php

namespace Dawnstar\Core\Database\seeds;

use Dawnstar\Core\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $admin = Admin::create([
            'status' => 1,
            'first_name' => 'Test',
            'last_name' => 'Test',
            'email' => 'test@test.com',
            'password' => Hash::make('123123'),
        ]);

        $role = Role::create([
            'name' => 'Super Admin',
            'guard_name' => 'admin'
        ]);


        $admin->assignRole($role);
    }
}
