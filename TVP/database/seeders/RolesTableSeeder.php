<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use jeremykenedy\LaravelRoles\Models\Role;

class RolesTableSeeder extends Seeder
{
    public function run(): void
    {
        Role::create(
            [
                'name' => 'Admin',
                'slug' => 'admin',
                'description' => 'Admin Role',
                'level' => 99,
            ]
        );
        Role::create(
            [
                'name' => 'Unconfirmed User',
                'slug' => 'unconfirmeduser',
                'description' => 'User Role (unconfirmed)',
                'level' => 1,
            ]
        );
        Role::create(
            [
                'name' => 'User',
                'slug' => 'user',
                'description' => 'User Role (Verified)',
                'level' => 2,
            ]
        );
    }
}
