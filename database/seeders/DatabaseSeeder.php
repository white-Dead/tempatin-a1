<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'full_name' => 'Admin Tempatin',
            'email'     => 'admin@tempatin.id',
            'password'  => Hash::make('password'),
            'role'      => 'admin',
            'status'    => 'active',
        ]);

        // Demo user
        User::create([
            'full_name' => 'Pengguna Demo',
            'email'     => 'user@tempatin.id',
            'password'  => Hash::make('password'),
            'role'      => 'user',
            'status'    => 'active',
        ]);

        $this->call([
            FacilitySeeder::class,
            PlaceSeeder::class,
        ]);
    }
}
