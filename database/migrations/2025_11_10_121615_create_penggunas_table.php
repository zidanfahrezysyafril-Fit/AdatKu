<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('penggunas', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama', 50);
            $table->string('email', 50)->unique();
            $table->string('no_wa', 50);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penggunas');
    }
};
