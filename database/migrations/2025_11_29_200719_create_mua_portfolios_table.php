<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mua_portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mua_id')
                  ->constrained('muas')     // sesuaikan kalau nama tabel MUA beda
                  ->onDelete('cascade');    // kalau MUA dihapus, fotonya ikut hilang
            $table->string('foto_path');     // path file gambar di storage
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mua_portfolios');
    }
};
