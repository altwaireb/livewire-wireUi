<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::firstOrCreate([
            'name' => 'Administrator',
            'key' => 'administrator',
            'color' => '#7f1d1d',
            'default' => 0
        ]);

        Role::firstOrCreate([
            'name' => 'Admin',
            'key' => 'admin',
            'color' => '#ef4444',
            'default' => 0
        ]);

        Role::firstOrCreate([
            'name' => 'Moderator',
            'key' => 'moderator',
            'color' => '#166534',
            'default' => 0
        ]);

        Role::firstOrCreate([
            'name' => 'User',
            'key' => 'user',
            'color' => '#000',
            'default' => 1
        ]);

        Role::firstOrCreate([
            'name' => 'Waiting',
            'key' => 'waiting',
            'color' => '#fbbf24',
            'default' => 0
        ]);

        Role::firstOrCreate([
            'name' => 'Banned',
            'key' => 'banned',
            'color' => '#a1a1aa',
            'default' => 0
        ]);

        // Add Permissions to Role Administrator
        $permission_administrator = Permission::where('key','!=','banned')->pluck('id')->toArray();

        $admin_role = Role::where('key','administrator')->first();
        $admin_role->permissions()->sync($permission_administrator);

        // Add Permissions to Role Banned
        $permission_banned = Permission::where('key','banned')->pluck('id')->toArray();
        $banned_role = Role::where('key','banned')->first();
        $banned_role->permissions()->sync($permission_banned);

    }
}
