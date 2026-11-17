<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        Schema::create('lpks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('slug')->unique();
            $table->string('bidang');
            $table->string('tagline')->nullable();
            $table->text('tentang')->nullable();
            $table->string('cover')->nullable();
            $table->string('logo')->nullable();
            $table->string('ikon')->default('🏛️');
            $table->string('warna')->default('#0b5d63');
            $table->string('nama_admin')->nullable();
            $table->string('whatsapp')->nullable();
            $table->text('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
            $table->text('link_maps')->nullable();
            $table->integer('urutan')->default(0);
            $table->boolean('aktif')->default(true);
            $table->timestamps();
        });

        Schema::create('lpk_services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpk_id')->constrained('lpks')->cascadeOnDelete();
            $table->string('nama_layanan');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('lpk_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpk_id')->constrained('lpks')->cascadeOnDelete();
            $table->string('foto');
            $table->string('keterangan')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('lpk_partners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpk_id')->constrained('lpks')->cascadeOnDelete();
            $table->string('nama_mitra');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });

        Schema::create('lpk_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lpk_id')->constrained('lpks')->cascadeOnDelete();
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('ikon')->default('✨');
            $table->integer('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lpk_features');
        Schema::dropIfExists('lpk_partners');
        Schema::dropIfExists('lpk_galleries');
        Schema::dropIfExists('lpk_services');
        Schema::dropIfExists('lpks');
        Schema::dropIfExists('settings');
    }
};

