<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->id();

            // relasi ke users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // data tambahan profil pengguna
            $table->string('no_wa')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kota')->nullable();

            $table->timestamps();

            $table->unique('user_id'); // 1 user cuma boleh punya 1 profil pengguna
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
