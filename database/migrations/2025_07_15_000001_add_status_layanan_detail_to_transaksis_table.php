<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('transaksis', 'status_layanan_detail')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->json('status_layanan_detail')->nullable()->after('keterangan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('transaksis', 'status_layanan_detail')) {
            Schema::table('transaksis', function (Blueprint $table) {
                $table->dropColumn('status_layanan_detail');
            });
        }
    }
}; 