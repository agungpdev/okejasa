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
        Schema::create('jasa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idkategori')->references('id')->on('kategori')->onDelete('cascade');
            $table->string('namajasa');
            $table->string('gambar');
            $table->string('deskripsi');
            $table->integer('rating');
            $table->integer('hargasebelum');
            $table->integer('hargasetelah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jasa');
    }
};
