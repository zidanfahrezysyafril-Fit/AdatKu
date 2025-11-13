<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('layanans', function (Blueprint $t) {
            $t->uuid('id')->primary();
            $t->uuid('mua_id');                         
            $t->string('nama', 120);
            $t->unsignedBigInteger('harga')->default(0);
            $t->string('kategori', 40)->nullable();    
            $t->text('deskripsi')->nullable();
            $t->string('foto', 255)->nullable();
            $t->timestamps();

            $t->foreign('mua_id')->references('id')->on('muas')->cascadeOnDelete();
            $t->index(['mua_id', 'kategori']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
