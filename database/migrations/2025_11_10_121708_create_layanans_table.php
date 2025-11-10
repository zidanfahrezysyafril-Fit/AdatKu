<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('layanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_mua');
            $table->string('nama_layanan');
            $table->decimal('harga', 15, 2)->nullable();
            $table->timestamps();

            $table->foreign('id_mua')->references('id')->on('muas')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('layanans');
    }
};
