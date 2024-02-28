<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = ['Superuser'];
        foreach ($roles as $value) {
            $role = \App\Models\Role::firstOrNew(['name' => $value]);
            $role->save();
        }
    }
}
