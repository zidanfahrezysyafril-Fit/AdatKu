<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id(); // AUTO_INCREMENT PK

            $table->foreignId('id_pesanan')
                ->constrained('pesanans')
                ->cascadeOnDelete();

            $table->date('tanggal_bayar');
            $table->enum('metode_bayar', ['Transfer_Bank', 'E_Wallet', 'COD']);
            $table->text('bukti_transfer')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
