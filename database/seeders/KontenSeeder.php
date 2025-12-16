<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\konten;

class KontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'judul' => 'Tentang Dimas Diajeng',
                'icon' => '',
                'deskripsi' => 'Mengenal lebih dekat peran, fungsi, serta tujuan Dimas Diajeng Sleman dalam mengangkat potensi daerah, mempromosikan pariwisata, dan menjadi teladan generasi muda di masyarakat.'
            ],
            [
                'judul' => 'Promosi Pariwisata',
                'icon' => 'Icon Pariwisata.png',
                'deskripsi' => 'Mempromosikan potensi pariwisata, seni, dan budaya di Yogyakarta kepada masyarakat luas.'
            ],
            [
                'judul' => 'Teladan Generasi Muda',
                'icon' => 'Icon Teladan.png',
                'deskripsi' => 'Menjadi teladan bagi generasi muda dengan nilai-nilai luhur seperti unggah-ungguh dan tepa selira.'
            ],
            [
                'judul' => 'Jembatan Komunikasi',
                'icon' => 'Icon Komunikasi.png',
                'deskripsi' => 'Berperan aktif sebagai jembatan komunikasi antara masyarakat, pemerintah, dan pelaku pariwisata.'
            ]
            ];
        foreach ($items as $item) {
            konten::create($item);
        }
    }
}
