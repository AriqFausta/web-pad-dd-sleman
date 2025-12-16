<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organisasi_Card;

class OrganisasiCardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 9; $i++) {
            Organisasi_Card::create([
                'organisasi_id' => 1,
                'foto' => 'organisasi/CardAnggota.png',
                'nama' => 'Denise Aditya',
                'jabatan' => 'Jabatan ' . $i,
            ]);
        }
    }
}
