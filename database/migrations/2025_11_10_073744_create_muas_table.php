<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('muas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_usaha', 100);
            $table->string('kontak_wa', 20)->unique();
            $table->string('alamat')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('instagram', 100)->nullable();
            $table->string('tiktok', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique('user_id');
            $table->index('user_id');
        });
    }
    public function down(): void {
        Schema::dropIfExists('muas');
    }
};