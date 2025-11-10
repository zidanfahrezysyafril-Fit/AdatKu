<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id('Id_Pesanan');
            $table->unsignedBigInteger('Id_Pengguna');
            $table->unsignedBigInteger('Id_Layanan');
            $table->date('Tanggal_Booking');
            $table->text('Alamat');
            $table->decimal('Total_Harga', 12, 2);
            $table->enum('Status_Pembayaran', ['Belum_Lunas', 'Lunas', 'Dibatalkan'])->default('Belum_Lunas');
            $table->timestamps();

            $table->foreign('Id_Pengguna')->references('Id_Pengguna')->on('pengguna')->onDelete('cascade');
            $table->foreign('Id_Layanan')->references('Id_Layanan')->on('layanan')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pesanan');
    }
};
