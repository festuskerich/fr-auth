<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'user:read',
            'label' => 'User Read',
        ]);
        Permission::create([
            'name' => 'user:write',
            'label' => 'User Write',
        ]);
        Permission::create([
            'name' => 'user:update',
            'label' => 'User Update',
        ]);
        Permission::create([
            'name' => 'user:delete',
            'label' => 'User Delete',
        ]);
    }
}
