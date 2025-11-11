<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->uuid('id')->primary(); // UUID agar sesuai dengan pesanans.id
            $table->uuid('id_pesanan');    // FK ke pesanans.id
            $table->date('tanggal_bayar');
            $table->enum('metode_bayar', ['Transfer_Bank', 'E_Wallet', 'COD']);
            $table->text('bukti_transfer')->nullable();
            $table->enum('status_verifikasi', ['Menunggu', 'Diterima'])->default('Menunggu');
            $table->timestamps();

            $table->foreign('id_pesanan')->references('id')->on('pesanans')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pembayarans');
    }
};
