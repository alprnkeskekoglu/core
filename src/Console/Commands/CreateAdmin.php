<?php

namespace Dawnstar\Console\Commands;

use Dawnstar\Models\Admin;
use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    protected $signature = 'ds:admin';

    public $firstName;
    public $lastName;
    public $email;
    public $password;

    public function handle()
    {
        $this->firstName = $this->ask('Name');
        $this->lastName = $this->ask('Surname');

        while (true) {
            $email = $this->ask('Email address to use when signing in');

            if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->email = $email;
                break;
            } else {
                $this->error('Email address is not valid!');
            }
        }

        $this->password = $this->secret('Password');

        $this->createAdmin();

        $this->info(PHP_EOL . 'Admin was created. You can login via "/dawnstar" with your email and password.' . PHP_EOL);
    }

    private function createAdmin()
    {
        $data = [
            'role_id' => 1,
            'status' => 1,
            'fullname' => trim($this->firstName) . ' ' . trim($this->lastName),
            'username' => trim($this->firstName),
            'email' => $this->email,
            'password' => bcrypt($this->password),
        ];

        $admin = Admin::create($data);
    }
}
