<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jadwal_layanans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hewan_id');
            $table->unsignedBigInteger('layanan_id');
            $table->string('jam_mulai');
            $table->string('jam_selesai');
            $table->enum('status', ['menunggu', 'proses', 'selesai', 'dibatalkan'])->default('menunggu');
            $table->text('keterangan')->nullable();
            $table->foreign('hewan_id')->references('id')->on('hewan_peliharaans')->onDelete('cascade');
            $table->foreign('layanan_id')->references('id')->on('layanans')->onDelete('cascade');
            $table->date('tanggal');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_layanans');
    }
};
