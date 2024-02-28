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
        Schema::create('administrators', function (Blueprint $table) {
            $table->increments('id_administrator');
            $table->string('nama_administrator', 64);
            $table->text('alamat');
            $table->string('no_telepon', 16);
            $table->unsignedInteger('pengguna_id');
            $table->foreign('pengguna_id')->references('id_pengguna')->on('penggunas')->noActionOnDelete()->noActionOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('administrators');
    }
};