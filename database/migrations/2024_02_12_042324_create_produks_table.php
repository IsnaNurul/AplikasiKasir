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
        Schema::create('produks', function (Blueprint $table) {
            $table->string('kode_produk', 8);
            $table->string('nama_produk', 64);
            $table->tinyText('gambar_produk');
            $table->tinyText('deskripsi_produk')->nullable();
            $table->integer('harga');
            $table->integer('stok');
            $table->date('tanggal_kadaluarsa')->nullable();
            $table->unsignedInteger('kategori_produk_id');
            $table->unsignedInteger('diskon_produk_id')->nullable();
            $table->foreign('kategori_produk_id')->references('id_kategori_produk')->on('kategori_produks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('diskon_produk_id')->references('id_diskon_produk')->on('diskon_produks')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
            $table->primary('kode_produk');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
