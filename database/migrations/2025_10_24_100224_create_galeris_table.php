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
        Schema::create('galeris', function (Blueprint $table) {
            $table->id('galeri_id');
            $table->string('nama');
            $table->string('kategori');
            $table->string('foto');
            $table->string('tahun');
            $table->string('instagram_dim');
            $table->string('link_instagram_dim');
            $table->string('instagram_dia');
            $table->string('link_instagram_dia');
            $table->longtext('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeris');
    }
};
