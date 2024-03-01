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
        Schema::create('pengirimen', function (Blueprint $table) {
            $table->increments('id_pengiriman');
            $table->date('tanggal_pengiriman');
            $table->string('biaya_pengiriman', 45);
            $table->enum('status_pengiriman', ['proses', 'diterima', 'dibatalkan']);
            $table->unsignedInteger('penjualan_id');
            $table->text('alamat_pengiriman')->nullable();
            $table->string('nama_penerima')->nullable();
            $table->foreign('penjualan_id')->references('id_penjualan')->on('penjualans')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengirimen');
    }
};
