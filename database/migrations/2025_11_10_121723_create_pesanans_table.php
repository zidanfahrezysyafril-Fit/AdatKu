<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->uuid('id')->primary(); // primary key UUID
            $table->uuid('id_pengguna');   // FK ke penggunas.id
            $table->uuid('id_layanan');    // FK ke layanans.id
            $table->date('tanggal_booking');
            $table->text('alamat');
            $table->decimal('total_harga', 12, 2);
            $table->enum('status_pembayaran', ['Belum_Lunas', 'Lunas', 'Dibatalkan'])->default('Belum_Lunas');
            $table->timestamps();

            $table->foreign('id_pengguna')->references('id')->on('penggunas')->onDelete('cascade');
            $table->foreign('id_layanan')->references('id')->on('layanans')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('pesanans');
    }
};
