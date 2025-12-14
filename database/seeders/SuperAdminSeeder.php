<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class SuperAdminSeeder extends Seeder
{
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'Den@ur.e'],
            [
                'name' => 'Super Admin',
                'phone' => '08213456789',
                'role' => 'super_admin',
                // password disimpan sebagai hash, bukan plain text
                'password' => '$2y$12$0X0PYWhePBuYoBeWsp0AvOEFzblo7TtEZhOXTJi0U2Ny9hEpWVvC6',
            ]
        );
    }
}