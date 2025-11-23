<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('keranjangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('id_pengguna')->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_layanan')->constrained('layanans')->cascadeOnDelete();
            $table->integer('jumlah')->default(1); // default 1 item aja
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('keranjangs');
    }
};
