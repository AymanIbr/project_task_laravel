<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Permission::create(['name'=>'Create-','guard_name'=>'admin']);
        // Permission::create(['name'=>'Read-','guard_name'=>'admin']);
        // Permission::create(['name'=>'Update-','guard_name'=>'admin']);
        // Permission::create(['name'=>'Delete-','guard_name'=>'admin']);

        // Permission::create(['name' => 'Create-Note', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Read-Notes', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Update-Note', 'guard_name' => 'user']);
        // Permission::create(['name' => 'Delete-Note', 'guard_name' => 'user']);
    }
}
