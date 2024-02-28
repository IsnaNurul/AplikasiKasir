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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->increments('id_penjualan');
            $table->string('kode_transaksi', 20);
            $table->dateTime('tanggal_jual');
            $table->enum('metode_pembayaran', ['cash', 'transfer']);
            $table->unsignedInteger('pelanggan_id')->nullable();
            $table->unsignedInteger('pengguna_id');
            $table->enum('status', ['selesai', 'ditunda', 'dibatalkan']);
            $table->enum('tipe_penjualan', ['dine in', 'take away', 'online']);
            $table->double('total_harga')->nullable();
            $table->double('jumlah_bayar')->nullable();
            $table->string('rekening_tujuan', 30)->nullable();
            $table->foreign('pelanggan_id')->references('id_pelanggan')->on('pelanggans')->noActionOnDelete()->noActionOnUpdate();
            $table->foreign('pengguna_id')->references('id_pengguna')->on('penggunas')->noActionOnDelete()->noActionOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
