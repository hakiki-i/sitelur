<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->boolean('is_po')->default(false)->after('kekurangan');
            $table->date('tanggal_ambil')->nullable()->after('is_po');
            $table->string('status_po', 20)->nullable()->after('tanggal_ambil'); // null, 'pending', 'diambil'
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['is_po', 'tanggal_ambil', 'status_po']);
        });
    }
};
