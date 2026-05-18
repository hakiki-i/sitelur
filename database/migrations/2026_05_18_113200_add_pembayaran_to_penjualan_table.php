<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->string('status_pembayaran')->default('lunas')->after('total');
            $table->integer('dibayar')->default(0)->after('status_pembayaran');
            $table->integer('kekurangan')->default(0)->after('dibayar');
        });
    }

    public function down(): void
    {
        Schema::table('penjualan', function (Blueprint $table) {
            $table->dropColumn(['status_pembayaran', 'dibayar', 'kekurangan']);
        });
    }
};
