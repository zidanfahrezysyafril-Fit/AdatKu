<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanan', function (Blueprint $table) {
            $table->id('Id_Layanan');
            $table->unsignedBigInteger('Id_Mua');
            $table->unsignedBigInteger('Id_Pengguna');
            $table->string('Nama_Layanan', 100);
            $table->string('Kategori', 50);
            $table->text('Deskripsi')->nullable();
            $table->string('Ukuran_Status', 50);
            $table->decimal('Harga', 12, 2);
            $table->timestamps();

            $table->foreign('Id_Mua')->references('Id_Mua')->on('mua')->onDelete('cascade');
            $table->foreign('Id_Pengguna')->references('Id_Pengguna')->on('pengguna')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('layanan');
    }
};
