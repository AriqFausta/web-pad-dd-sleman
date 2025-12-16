<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\kategori;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Kegiatan'],
            ['nama_kategori' => 'Pengumuman'],
            ['nama_kategori' => 'Berita Umum'],
            ['nama_kategori' => 'Event'],
            ['nama_kategori' => 'Prestasi'],
        ];

        foreach ($kategoris as $kategori) {
            kategori::create($kategori);
        }
    }
}
