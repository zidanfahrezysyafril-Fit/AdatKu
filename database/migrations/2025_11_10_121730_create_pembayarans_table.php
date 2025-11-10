<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id('Id_Pembayaran');
            $table->unsignedBigInteger('Id_Pesanan');
            $table->date('Tanggal_Bayar');
            $table->enum('Metode_Bayar', ['Transfer_Bank', 'E_Wallet', 'COD']);
            $table->text('Bukti_Transfer')->nullable();
            $table->enum('Status_Verifikasi', ['Menunggu', 'Diterima'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('Id_Pesanan')->references('Id_Pesanan')->on('pesanan')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembayaran');
    }
};
