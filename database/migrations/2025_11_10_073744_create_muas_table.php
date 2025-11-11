<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('muas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // relasi ke user
            $table->string('nama_usaha', 100);
            $table->string('kontak_wa', 20)->unique();
            $table->string('nomor_rekening', 20)->nullable()->unique();
            $table->string('profile_mua')->nullable(); // foto MUA
            $table->string('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('muas');
    }
};
