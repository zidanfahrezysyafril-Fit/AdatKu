<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('muas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_usaha', 100);
            $table->string('kontak_wa', 20)->unique();
            $table->string('nomor_rekening',20)->unique();
            $table->string('profile_mua');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('muas');
    }
};
