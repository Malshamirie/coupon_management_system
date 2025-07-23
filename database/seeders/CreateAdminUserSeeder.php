<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{


    public function run(): void
    {


        $user2 = User::create([
            'name' => 'admin2',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123123')
        ]);

        $role = Role::create(['name' => 'Admin']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);

        $user2->assignRole([$role->id]);
    }


}
