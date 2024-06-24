<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::Create([
            'name' => 'Admin',
            'email' => 'admin@admin',
            'role_id' => Role::SUPER_ADMIN,
            'password' => Hash::make('admin'),
        ]);

        $adminPermissions = Permission::all();
        $user->permissions()->sync($adminPermissions);
    }
}
