<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create a default admin user
        Admin::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin1234'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Create additional admin users using factory if in development environment
        if (app()->environment(['local', 'development'])) {
            Admin::factory()->count(5)->create();
        }
    }
}
