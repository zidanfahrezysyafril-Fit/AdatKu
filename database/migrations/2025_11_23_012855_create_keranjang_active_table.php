<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('keranjang_active', function (Blueprint $table) {
            $table->foreignId('id_pengguna')->primary()->constrained('users')->cascadeOnDelete();
            $table->foreignId('id_mua')->constrained('muas')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('keranjang_active');
    }
};
