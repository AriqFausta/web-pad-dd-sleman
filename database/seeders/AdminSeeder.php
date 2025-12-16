<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Cek apakah admin sudah ada
        $admin = User::where('email', 'admin@dimasdiajeng.com')->first();

        if (!$admin) {
            User::create([
                'name' => 'Administrator',
                'email' => 'admin@dimasdiajeng.com',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]);

            $this->command->info('✅ Admin user berhasil dibuat!');
            $this->command->info('📧 Email: admin@dimasdiajeng.com');
            $this->command->info('🔑 Password: admin123');
        } else {
            $this->command->warn('⚠️  Admin user sudah ada!');
        }
    }
}
