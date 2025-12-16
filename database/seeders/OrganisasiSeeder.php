<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Organisasi;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Organisasi::create([
            'gambar_struktur_organisasi' => 'organisasi/fotoOrganisasi.png',
            'tahun' => '2025',
            'visi_misi' => '<h2 class="fw-bold mb-3">VISI & MISI</h2>
<p>
Menjadi organisasi pemuda yang berperan aktif sebagai duta budaya, pariwisata, dan komunikasi...
</p>
<ol>
<li><strong>Promosi Wisata</strong></li>
<p>Meningkatkan dan mempromosikan potensi pariwisata daerah...</p>
<li><strong>Pelestarian Budaya</strong></li>
<p>Melestarikan seni, budaya, dan tradisi lokal...</p>
<li><strong>Pemberdayaan Generasi Muda</strong></li>
<p>Membangun jiwa kepemimpinan dan kolaborasi bagi generasi muda...</p>
<li><strong>Jembatan Komunikasi</strong></li>
<p>Menjadi penghubung antara masyarakat, pemerintah, dan pelaku pariwisata...</p>
<li><strong>Kontribusi Sosial</strong></li>
<p>Berperan aktif dalam kegiatan sosial, lingkungan, dan kemanusiaan...</p>
</ol>',
        ]);
    }
}
