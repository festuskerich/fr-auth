<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $managerole=Permission::where('name','user:read')->first();
        $manageuser=Permission::where('name','user:write')->first();

        $user=Role::create([
            'name'=>'USER',
            'label'=>'User',
        ]);
         $admin=Role::create([
            'name'=>'ADMIN',
            'label'=>'System Admin',
        ]);
        $admin->allowTo($managerole);
        $user->allowTo($manageuser);
    }
}
