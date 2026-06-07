<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            // Kolom untuk Grade A (rename semantik, existing columns)
            // jumlah        -> jumlah Grade A
            // harga_perkilo -> harga Grade A per kg

            // Kolom baru untuk Grade B
            $table->decimal('jumlah_b', 10, 2)->nullable()->after('jumlah')->default(0);
            $table->integer('harga_perkilo_b')->nullable()->after('harga_perkilo')->default(0);
            $table->integer('total_b')->nullable()->after('total')->default(0);

            // jenis_telur sekarang bisa: 'layak', 'tidak_layak', 'keduanya'
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['jumlah_b', 'harga_perkilo_b', 'total_b']);
        });
    }
};
