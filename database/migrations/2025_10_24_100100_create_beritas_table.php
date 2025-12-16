<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('beritas', function (Blueprint $table) {
                $table->bigIncrements('berita_id');
                // FK ke kategoris.kategori_id (nullable, jika kategori dihapus → set null)
                $table->foreignId('kategori_id')
                      ->nullable()
                      ->constrained('kategoris', 'kategori_id')
                      ->nullOnDelete();

                $table->string('judul_berita', 255);
                $table->string('gambar_berita', 255)->nullable();
                $table->longText('isi_berita');
                $table->boolean('carousel_active')->default(false)->index();
                $table->timestamps();

                $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
