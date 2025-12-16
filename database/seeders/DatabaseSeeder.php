<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\konten;
use App\Models\kategori;
use App\Models\Organisasi_Card;
use App\Models\Organisasi;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

            $this->call([
            AdminSeeder::class,
            KategoriSeeder::class,
            KontenSeeder::class,
            OrganisasiCardSeeder::class,
            OrganisasiSeeder::class,
            
        ]);

        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );
    }
}
