<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // definir los permisos reales que se van a crear en la DB
        $permissions = [
            'access dashboard',
            'manage categories',
            'manage posts',
            'manage permissions',
            'manage roles',
            'manage users',
        ];

        // obtener cada permiso del array $permissions y crear los permisos con el modelo Permission,
        // en el campo name de la tabla permissions de la DB
        foreach ($permissions as $permission) {
            Permission::create([
                'name' => $permission
            ]);
        }
    }
}
