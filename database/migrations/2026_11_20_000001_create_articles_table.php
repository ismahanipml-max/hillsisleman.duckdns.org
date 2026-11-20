<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->string('kategori')->default('Pelatihan Vokasi');
            $table->string('tanggal')->default('10 Maret 2026');
            $table->string('penulis')->nullable()->default('Pengurus DPC HILLSI');
            $table->string('sumber')->nullable();
            $table->string('sumber_teks')->nullable();
            $table->string('foto')->nullable();
            $table->string('ikon')->default('📰');
            $table->string('warna')->default('#0e4c54');
            $table->text('ringkasan')->nullable();
            $table->json('isi')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
