<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\RolesEnum;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $input = [
            RolesEnum::ADMIN,
            RolesEnum::AGENT,
            RolesEnum::CUSTOMER,
        ];

        foreach ($input as $value) {
            Role::create([
                'name' => $value,
                'guard_name' => 'web'
            ]);
        }
    }
}
