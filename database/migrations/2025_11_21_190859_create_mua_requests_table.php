<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mua_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('nama_usaha', 100);
            $table->string('kontak_wa', 20);
            $table->string('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('tiktok', 100)->nullable();
            $table->string('foto')->nullable(); // nanti kalau mau upload foto usaha

            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();

            $table->timestamps();

            $table->unique('user_id'); // satu user satu pengajuan aktif
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mua_requests');
    }
};
