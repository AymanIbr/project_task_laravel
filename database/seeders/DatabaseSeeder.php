<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);


        Permission::create(['name' => 'Create-Note', 'guard_name' => 'user']);
        Permission::create(['name' => 'Read-Notes', 'guard_name' => 'user']);
        Permission::create(['name' => 'Update-Note', 'guard_name' => 'user']);
        Permission::create(['name' => 'Delete-Note', 'guard_name' => 'user']);
    }
}
