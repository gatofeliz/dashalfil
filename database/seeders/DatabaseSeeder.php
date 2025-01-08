<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $viewer = Role::create(['name' => 'espectador']);
        $assigner = Role::create(['name' => 'asignador']);

        $assign = Permission::create(['name' => 'assign links']);
        $view = Permission::create(['name' => 'view links']);

        $assigner->givePermissionTo($assign);
        $viewer->givePermissionTo($view);

        $admin = \App\Models\User::factory()->create([
            'name' => '4dm1n',
            'email' => 'urielezequiel1@outlook.es',
        ]);
        $admin->assignRole(Role::create([
            'name' => 'admin',
        ]));

        $user1 = \App\Models\User::factory()->create([
            'name' => 'Asignador',
            'email' => 'a@a.com',
        ]);
        $user1->assignRole($assigner);

        $user2 = \App\Models\User::factory()->create([
            'name' => 'Espectador',
            'email' => 'e@e.com',
        ]);
        $user2->assignRole($viewer);
    }
}
