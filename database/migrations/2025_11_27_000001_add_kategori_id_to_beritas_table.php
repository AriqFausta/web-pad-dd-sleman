<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Sesuaikan tipe dengan tabel kategoris (bigIncrements vs increments)
            // Jika kategoris pakai bigIncrements:
            $table->unsignedBigInteger('kategori_id')->nullable()->after('berita_id');
            $table->foreign('kategori_id')
                  ->references('kategori_id')
                  ->on('kategoris')
                  ->nullOnDelete(); // Laravel 11+; jika error ganti ->onDelete('set null')
        });
    }

    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropForeign(['kategori_id']);
            $table->dropColumn('kategori_id');
        });
    }
};
