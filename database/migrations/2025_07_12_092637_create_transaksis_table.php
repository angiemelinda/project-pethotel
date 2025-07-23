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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggans')->onDelete('cascade');
            $table->foreignId('hewan_id')->constrained('hewan_peliharaans')->onDelete('cascade');
            $table->enum('jenis_layanan', ['penitipan', 'grooming', 'vaksinasi', 'checkup']);
            $table->date('tanggal_masuk');
            $table->date('tanggal_keluar')->nullable();
            $table->decimal('total_harga', 10, 2);
            $table->enum('metode_pembayaran', ['cash', 'transfer', 'qris', 'dana', 'ovo', 'gopay'])->default('cash');
            $table->enum('status_pembayaran', ['belum_lunas', 'dp', 'lunas'])->default('belum_lunas');
            $table->decimal('jumlah_dibayar', 10, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->json('status_layanan_detail')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
