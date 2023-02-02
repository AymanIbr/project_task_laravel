<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Role as ModelsRole;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ModelsRole::create(['name'=>'Super-Admin','guard_name'=>'admin']);
        // ModelsRole::create(['name'=>'Content Management','guard_name'=>'admin']);
        // ModelsRole::create(['name'=>'Human Resources','guard_name'=>'admin']);
    }
}
