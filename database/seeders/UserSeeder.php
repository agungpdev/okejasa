<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = Role::create(['name'=>'Administrator']);
        $permission = Permission::create(['name'=>'Pengaturan']);
        $role->givePermissionTo($permission);
        $admin = User::create([
            'name'=>'Agung Saputra',
            'email'=>'admin@gmail.com',
            'password'=>Hash::make('Admin123')
        ]);
        $admin->assignRole($role);
    }
}
