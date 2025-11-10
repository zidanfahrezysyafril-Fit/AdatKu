<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pengguna', function (Blueprint $table) {
            $table->id('Id_Pengguna');
            $table->string('Nama', 50);
            $table->string('Email', 50)->unique();
            $table->string('No_Wa', 50);
            $table->string('Password', 50);
            $table->enum('Role', ['Pengguna', 'MUA', 'Admin']);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('pengguna');
    }
};
