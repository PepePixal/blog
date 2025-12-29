<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder; 
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Definir los roles
        $roles = [
            'admin' => [
                'access dashboard',
                'manage categories',
                'manage posts',
                'manage permissions',
                'manage roles',
                'manage users',
            ],
            'bloguer' => [
                'access dashboard',
                'manage categories',
                'manage posts',
            ],
        ];

        // iterar sobre los roles y obtener la llave ($name) y el valor ($permissions)
        foreach ($roles as $name => $permissions) {

            // Crear el rol
            $role = Role::create([
                'name' => $name
            ]);

            // Asignar automáticamente los permisos al rol, en la tabla pivot role_has_permissions
            $role->syncPermissions($permissions);
        }
    }
}
