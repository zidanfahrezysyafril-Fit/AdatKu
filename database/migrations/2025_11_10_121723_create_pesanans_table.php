<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
         Schema::create('pesanans', function (Blueprint $table) {
            $table->id(); // PRIMARY auto increment sesuai relasi lain

            // relasi ke user
            $table->foreignId('id_pengguna')
                ->constrained('users')
                ->cascadeOnDelete();

            // relasi ke layanan
            $table->foreignId('id_layanan')
                ->constrained('layanans')
                ->cascadeOnDelete();

            $table->date('tanggal_booking');
            $table->text('alamat');
            $table->decimal('total_harga', 12, 2);

            $table->enum('status_pembayaran', ['Belum_Lunas', 'Lunas', 'Dibatalkan'])
                ->default('Belum_Lunas');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
