<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Galeri;

class GaleriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Galeri::create([
                'nama' => 'Dimas & Diajeng ' . $i,
                'kategori' => 'juara ' . $i,
                'foto' => 'galeri/dimasdiajeng.png',
                'tahun' => '2025',
                'instagram_dim' => '@dimasdiajeng',
                'link_instagram_dim' => 'https://instagram.com/dimasdiajeng',
                'instagram_dia' => '@dimasdiajeng',
                'link_instagram_dia' => 'https://instagram.com/dimasdiajeng',
                'deskripsi' => "<p>Deskripsi Quill untuk Dimas Diajeng ke-$i. Ini data dummy untuk testing tampilan.</p>"
            ]);
        }
    }
}
